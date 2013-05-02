<?php

class XXX_I18n_Localization
{
	const CLASS_NAME = 'XXX_I18n_Localization';
	
	public static $selectedLocalization = 'us';
	
	public static $loadedLocalizations = array
	(
	);
	
	public static function initialize ()
	{
		self::loadLocalization(self::$selectedLocalization);
	}
	
	public static function loadLocalization ($localization = false, $select = true)
	{
		global $XXX_I18n_Localizations;
		
		if ($localization === false)
		{
			$localization = self::$selectedLocalization;
		}
		
		if (!XXX_Type::isArray($XXX_I18n_Localizations[$localization]))
		{
			$XXX_I18n_Localizations[$localization] = array();
		}
		
		$result = XXX_Path_Local::includeFile('localizations', $localization . XXX_OperatingSystem::$directorySeparator . 'localizations.' . $localization . '.php', false);
		
		if ($result)
		{
			if (!XXX_Array::hasKey(self::$loadedLocalizations, $localization))
			{
				self::$loadedLocalizations[] = $localization;
			}
		}
		
		if ($select)
		{
			self::$selectedLocalization = $localization;
		}
		
		return $result;
	}
	
	public static function get ()
	{
		global $XXX_I18n_Localizations;
		
		$exists = false;
		
		$result = false;
		
		$tempArguments = func_get_args();
		
		$firstArgument = $tempArguments[0];
		
		if (XXX_Type::isArray($firstArgument))
		{
			$tempArguments = $firstArgument;
		}
		
	 	if (XXX_Array::getFirstLevelItemTotal($tempArguments) >= 1)
	 	{
	 		$result = $XXX_I18n_Localizations[self::$selectedLocalization][$tempArguments[0]];
	 		
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
	 		if (self::$selectedLocalization != 'us')
			{
				$previousSelectedLocalization = self::$selectedLocalization;
				
				self::$selectedLocalization = 'us';
				
				$result = self::get($tempArguments);
				
				self::$selectedLocalization = $previousSelectedLocalization;
			}
			else
			{
	 			trigger_error('Unknown key: ' . XXX_Array::joinValuesToString($tempArguments, ', '), E_USER_WARNING);
	 		}
	 	}
	 	
	 	return $result;
	}
}


?>