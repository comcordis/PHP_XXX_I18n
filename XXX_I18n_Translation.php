<?php

/*

TODO Translation get and set service, making it possible that if a value does not exist to return a ticket that it needs to be translated 

OR Have a translation version of the website where codes are displayed by each translation so it's easy to label them

Problems:
	- Only load when needed
	- Have separate js files instead of 1 giant one when publishing to static
		- Can be done by setting the module before loading a file
		
	- When publishing all languages/modules have to be loaded?
	
Load english anyway

session setting
in route
in domain
in browser header
in geoip

When loading i18n stuff, prefix that its part of a module, so when publishing its published within the right module.

When adding query templates prefix them with the appropriate module

*/

abstract class XXX_I18n_Translation
{
	const CLASS_NAME = 'XXX_I18n_Translation';
	
	public static $selectedTranslation = 'en';
	
	public static $loadedTranslations = array
	(
	);
	
	public static $groups = array();
	
	public static function initialize ()
	{
		// TODO check browser or session or cookie for translation
		
		self::loadTranslation(self::$selectedTranslation);
	}
	
	public static function loadTranslation ($translation = false)
	{
		if ($translation === false)
		{
			$translation = self::$selectedTranslation;
		}
		
		$result = XXX_Path_Local::includeFile('translations', $translation . XXX_OperatingSystem::$directorySeparator . 'translations.' . $translation . '.php');
		
		if ($result)
		{
			if (!XXX_Array::hasKey(self::$loadedTranslations, $translation))
			{
				self::$loadedTranslations[] = $translation;
			}
		}
		
		return $result;
	}
	
	/*
	
	a group, belongs to a module?
	a path belongs to a module?
	
	translation
	groupName
	
	*/
	
	public static function addGroup ($translation = false, $groupName = '', $translations = array())
	{
		if ($translation === false)
		{
			$translation = self::$selectedTranslation;
		}
		
		if (!XXX_Type::isArray(self::$groups, $translation))
		{
			self::$groups[$translation] = array();
		}
		
		self::$groups[$translation][$groupName] = $translations;
	}
		
	public static function get ()
	{
		$exists = false;
		
		$result = false;
		
		$tempArguments = func_get_args();
		
	 	if (XXX_Array::getFirstLevelItemTotal($tempArguments) >= 1)
	 	{
	 		$result = self::$groups[self::$selectedTranslation][$tempArguments[0]];
	 		
	 		if ($result !== '')
	 		{	
				$exists = true;
				
			 	if (XXX_Array::getFirstLevelItemTotal($tempArguments) > 1)
			 	{
			 		// Traverse other arguments
			 		for ($i = 1, $iEnd = XXX_Array::getFirstLevelItemTotal($tempArguments); $i < $iEnd; ++$i)
			 		{
			 			$result = $result[$tempArguments[$i]];
			 			
			 			if ($result === '')
			 			{
			 				$result = false;
			 				
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
	 		trigger_error('Unknown key: ' . XXX_Array::joinValuesToString($tempArguments, ', '));
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