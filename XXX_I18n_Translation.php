<?php

/*	
	
Load english anyway

*/

abstract class XXX_I18n_Translation
{
	const CLASS_NAME = 'XXX_I18n_Translation';
	
	public static $selectedTranslation = 'en';
	public static $originalTranslation = false;
	
	public static $loadedTranslations = array
	(
	);
	
	public static function initialize ()
	{		
		self::loadTranslation(self::$selectedTranslation);
	}
	
	public static function loadTranslation ($translation = false, $select = true)
	{
		global $XXX_I18n_Translations;
		
		if ($translation === false)
		{
			$translation = self::$selectedTranslation;
		}
		
		if (!XXX_Type::isArray($XXX_I18n_Translations[$translation]))
		{
			$XXX_I18n_Translations[$translation] = array();
		}
		
		$result = XXX_Loader::loadFile('translations', $translation . XXX_OperatingSystem::$directorySeparator . 'translations.' . $translation . '.php', false);
		
		if ($result)
		{
			if (!XXX_Array::hasKey(self::$loadedTranslations, $translation))
			{
				self::$loadedTranslations[] = $translation;
			}
		}
		
		if ($select)
		{
			self::$selectedTranslation = $translation;
		}
		
		return $result;
	}
	
	
	public static function temporaryLoadTranslation ($translationCode = 'en')
	{
		if ($translationCode != '' && $translationCode != self::$selectedTranslation)
		{
			self::$originalTranslation = self::$selectedTranslation;
			
			self::loadTranslation($translationCode);
		}
	}
	
	public static function restoreOriginalTranslation ()
	{
		if (self::$originalTranslation)
		{
			self::loadTranslation(self::$originalTranslation);
		}
	}
		
	public static function get ()
	{
		global $XXX_I18n_Translations;
		
		$exists = false;
		
		$result = false;
		
		$tempArguments = func_get_args();
		
		$firstArgument = $tempArguments[0];
		
		if (XXX_Type::isArray($firstArgument))
		{
			$tempArguments = $firstArgument;
		}
		
		if (XXX_SpecialContext::$translator)
		{
			$tempArguments = XXX_Array::deleteFirstItem($tempArguments);
			$result = XXX_Array::joinValuesToString($tempArguments, '>');
		}
		else
		{		
		 	if (XXX_Array::getFirstLevelItemTotal($tempArguments) >= 1)
		 	{
		 		$result = $XXX_I18n_Translations[self::$selectedTranslation][$tempArguments[0]];
		 		
		 		if ($result !== '')
		 		{	
					$exists = true;
					
				 	if (XXX_Array::getFirstLevelItemTotal($tempArguments) > 1)
				 	{
				 		// Traverse other arguments
				 		for ($i = 1, $iEnd = XXX_Array::getFirstLevelItemTotal($tempArguments); $i < $iEnd; ++$i)
				 		{
				 			$result = $result[$tempArguments[$i]];
				 			
				 			if ($result == '')
				 			{
				 				//$result = 'Missing:' .XXX_Array::joinValuesToString($tempArguments, '>');
				 				$result = '';
				 				
								$exists = false;	 
				 				
				 				break;
				 			}
				 			else
				 			{
				 				$exists = true;
				 			}			 			
				 		}
				 	}
			 	}
			 	else
			 	{
			 		$exists = false;
			 	}
		 	}
		 	
		 	if ($exists === false)
		 	{
		 		if (self::$selectedTranslation != 'en')
				{
					$previousSelectedTranslation = self::$selectedTranslation;
					
					self::$selectedTranslation = 'en';
									
					$result = self::get($tempArguments);
					
					self::$selectedTranslation = $previousSelectedTranslation;
				}
				else
				{
		 			trigger_error('Unknown key: ' . XXX_Array::joinValuesToString($tempArguments, ', '), E_USER_WARNING);
		 		}
		 	}
	 	}
	 	
	 	return $result;
	}
	
	public static function composeSequence ($sequence = array())
	{
		$result = $sequence[0];
		
		for ($i = 1, $iEnd = XXX_Array::getFirstLevelItemTotal($sequence); $i < $iEnd; ++$i)
		{
			// Default
			$glue = self::get('sequence', 'between');
			
			// Last
			if ($i == $iEnd - 1)
			{
				if (self::get('sequence', 'last'))
				{
					$glue = self::get('sequence', 'last');
				}
			}			
			// First
			else if ($i == 1)
			{
				if (self::get('sequence', 'first'))
				{
					$glue = self::get('sequence', 'first');
				}
			}
			
			$result = $glue . $sequence[$i];
		}
		
		return $result;
	}
	
	public static function composeGrammaticalNumberForm ($text = '', $quantity = 1)
	{
		$result = $text;
		
		$quantity = XXX_Number::round($quantity);
		
		if (XXX_Type::isAssociativeArray($text) && !XXX_Type::isString($text))
		{
			if ($quantity == 1)
			{
				if (XXX_Type::isValue($text['singular']) || XXX_Type::isFilledArray($text['singular']))
				{
					$result = $text['singular'];
				}
			}
			else
			{
				if (XXX_Type::isValue($text['plural']) || XXX_Type::isFilledArray($text['plural']))
				{
					$result = $text['plural'];
				}
			}
		}
		
		return $result;
	}	
	
	public static function composeVariableText ($texts = '', $variables = array(), $quantity = 0)
	{
		if (!XXX_Type::isNumber($quantity))
		{
			$quantity = 0;
		}
		
		$quantity = XXX_Number::round($quantity);
		
		$message = self::composeGrammaticalNumberForm($texts, $quantity);
		
		$variableNames = array();
		$variableValues = array();
		
		foreach ($variables as $name => $value)
		{
			$variableNames[] = $name;
			$variableValues[] = $value;
		}
		
		$message = XXX_String::replaceVariables($message, $variableNames, $variableValues);
		
		return $message;
	}
}


?>