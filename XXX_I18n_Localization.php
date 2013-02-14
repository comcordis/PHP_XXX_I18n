<?php

class XXX_I18n_Localization
{
	const CLASS_NAME = 'XXX_I18n_Localization';
	
	public static $selectedLocalization = 'us';
	
	public static $loadedLocalizations = array
	(
	);
	
	public static $groups = array();
	
	public static function initialize ()
	{
		self::loadLocalization(self::$selectedLocalization);
	}
	
	public static function loadLocalization ($localization = false)
	{
		if ($localization === false)
		{
			$localization = self::$selectedLocalization;
		}
		
		$result = XXX_Path_Local::includeFile('localizations', $localization . XXX_OperatingSystem::$directorySeparator . 'localizations.' . $localization . '.php');
		
		if ($result)
		{
			if (!XXX_Array::hasKey(self::$loadedLocalizations, $localization))
			{
				self::$loadedLocalizations[] = $localization;
			}
		}
		
		return $result;
	}
	
	public static function addGroup ($localization = false, $groupName = '', $localizations = array())
	{
		if ($localization === false)
		{
			$localization = self::$selectedLocalization;
		}
		
		if (!XXX_Type::isArray(self::$groups, $localization))
		{
			self::$groups[$localization] = array();
		}
		
		self::$groups[$localization][$groupName] = $localizations;
	}
		
	public static function get ()
	{
		$exists = false;
		
		$result = false;
		
		$tempArguments = func_get_args();
		
	 	if (XXX_Array::getFirstLevelItemTotal($tempArguments) >= 1)
	 	{
	 		$result = self::$groups[self::$selectedLocalization][$tempArguments[0]];
	 		
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
	 		trigger_error('Unknown key: ' . XXX_Array::joinValuesToString($tempArguments, ', '));
	 	}
	 	
	 	return $result;
	}
}


?>