<?php

abstract class XXX_I18n_Currency
{
	public static $exchangeRates = array
	(
	);
	
	public static function initialize ()
	{
		$exchangeRates = array();
		
		$file = XXX_Path_Local::extendPath('data_cache_currencyExchangeRates', 'archive_' . XXX_TimestampHelpers::getTimestampPartForFile(true) . '.tmp');
		
		// Grab the external XML file only once a day
		if (XXX_FileSystem_Local::doesFileExist($file))
		{
			$exchangeRates = XXX_String_PHPON::decode(XXX_FileSystem_Local::getFileContent($file));
		}
		
		self::updateExchangeRates($exchangeRates);
	}
	
	public static function updateExchangeRates ($exchangeRates = array())
	{
		$result = false;
		
		$valid = true;
		
		if (XXX_Array::getDeepestLevel($exchangeRates) == 1 && XXX_Array::getFirstLevelItemTotal($exchangeRates))
		{
			foreach ($exchangeRates as $currencyCode => $exchangeRate)
			{
				if (!XXX_Type::isNumeric($exchangeRate) || XXX_String::getCharacterLength($currencyCode) != 3)
				{
					$valid = false;
					
					break;
				}
			}
		}
		else
		{
			$valid = false;
		}
		
		if ($valid)
		{
			self::$exchangeRates = XXX_Array::merge(self::$exchangeRates, $exchangeRates);
			
			$result = true;
		}
		
		return $result;
	}
	
	public static function getExchangeRatesExternal ($method = 'ecb')
	{
		$result = array();
		
		switch ($method)
		{
			case 'ecb':	
				//$xmlFile = FSH_Remote_HTTP::getFileContent('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
				
				if ($xmlFile)
				{			
					$result['eur'] = 1000;
					
					$patternMatches = XXX_String_Pattern::getMatches($xmlFile, 'currency=["\']([a-z0-9]*)["\'] rate=["\']([0-9.]*)["\']', 'i');
					
					for ($i = 0, $iEnd = XXX_Array::getFirstLevelItemTotal($patternMatches[0]); $i < $iEnd; ++$i)
					{
						$result[XXX_String::convertToLowerCase($patternMatches[1][$i])] = XXX_Type::makeFloat($patternMatches[2][$i]) * 1000;
					}
				}	
				break;
		}
		
		return $result;
	}
		
	public static function updateExchangeRatesExternal ()
	{
		$exchangeRates = XXX_I18n_Currency::getExchangeRatesExternal();
				
		// Only update files if valid
		if (self::updateExchangeRates($exchangeRates))
		{
			$file = XXX_Path_Local::extendPath('data_cache_currencyExchangeRates', 'archive_' . XXX_TimestampHelpers::getTimestampPartForFile(true) . '.tmp');
			
			$serializedExchangeRates = XXX_String_PHPON::encode($exchangeRates);
			
			XXX_FileSystem_Local::writeFileContent($file, $serializedExchangeRates);
		}
		
		return $exchangeRates;
	}
}

?>