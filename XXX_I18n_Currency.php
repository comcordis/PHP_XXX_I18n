<?php

abstract class XXX_I18n_Currency
{
	public static $maximumCacheAge = 86400; // 604800 ($maximumAttempts ook aanpassen)
	
	public static $cacheFilePath = '';
	
	public static function initialize ()
	{
		global $XXX_I18n_Currencies;
		
		$timestamp = new XXX_Timestamp();
				
		// Find newest existing cache file path
		$validFile = false;
		
		$maximumAttempts = 1; // 7
		$attempts = 0;
		
		while (true)
		{
			$timestampParts = XXX_TimestampHelpers::getTimestampPartsForPath($timestamp);
			$timestampPart = XXX_TimestampHelpers::getTimestampPartForFile($timestamp, true);
			
			
			self::$cacheFilePath = XXX_Path_Local::extendPath(XXX_Path_Local::$deploymentDataPathPrefix, array('i18n', 'currencies', $timestampParts['year'],  $timestampParts['month'],  $timestampParts['date'], 'currency_exchangeRates_' . $timestampPart. '.tmp'));
			
			
			if (self::isUpToDateCacheFileAvailable())
			{
				$validFile = true;
				
				self::retrieveStateFromCacheFile();
				
				break;
			}
			
			$timestamp->set($timestamp->get() - 86400);
			
			++$attempts;
			
			if ($attempts >= $maximumAttempts)
			{
				break;
			}
		}
		
		
		if (!$validFile)
		{
			$simplifiedExchangeRatesForCode = self::getExchangeRatesExternal();
			
			$XXX_I18n_Currencies['exchangeRates'] = $simplifiedExchangeRatesForCode;
			
			self::saveCurrentStateToCacheFile();
		}
	}
		
	public static function retrieveStateFromCacheFile ()
	{
		global $XXX_I18n_Currencies;
		
		$fileContent = XXX_FileSystem_Local::getFileContent(self::$cacheFilePath);
		$fileContent = XXX_String_PHPON::decode($fileContent);
		
		$XXX_I18n_Currencies['exchangeRates'] = $fileContent;
	}
	
	public static function saveCurrentStateToCacheFile ()
	{
		global $XXX_I18n_Currencies;
		
		XXX_FileSystem_Local::writeFileContent(self::$cacheFilePath, XXX_String_PHPON::encode($XXX_I18n_Currencies['exchangeRates']));
		
		$currenciesPath = XXX_Path_Local::extendPath(XXX_Path_Local::$deploymentDataPathPrefix, array('i18n', 'currencies'));
		
		XXX_FileSystem_Local::setDirectoryOwnerAdvanced($currenciesPath, 'apache', 'apache', true, true);
		
		XXX_FileSystem_Local::setDirectoryPermissions($currenciesPath, '770', true);			
		XXX_FileSystem_Local::setFilePermissionsInDirectory($currenciesPath, '660', true);
	}
	
	public static function isUpToDateCacheFileAvailable ()
	{
		$result = false;
		
		if (XXX_FileSystem_Local::doesFileExist(self::$cacheFilePath))
		{
			$now = XXX_TimestampHelpers::getCurrentTimestamp();
			
			$fileModifiedTimestamp = XXX_FileSystem_Local::getFileModifiedTimestamp(self::$cacheFilePath);
			
			if ($now - $fileModifiedTimestamp < self::$maximumCacheAge)
			{
				$result = true;
			}
		}
		
		return $result;
	}
	
	public static function composeExchangeRatesJS ()
	{
		global $XXX_I18n_Currencies;
		
		$result = 'XXX_I18n_Currencies.exchangeRates = ' . XXX_String_JSON::encode($XXX_I18n_Currencies['exchangeRates']) . ';';
		
		return $result;
	}
	
	public static function getCodeForCountry_code ($country_code = '')
	{
		global $XXX_I18n_Currencies;
		
		$result = false;
		
		foreach ($XXX_I18n_Currencies['information'] as $tempCurrencyInformation)
		{
			if (XXX_Array::hasValue($tempCurrencyInformation['country_codes'], $country_code))
			{
				$result = $tempCurrencyInformation['code'];
				
				break;
			}
		}
		
		return $result;
	}
		
	public static function getInformation ($code = '')
	{
		global $XXX_I18n_Currencies;
		
		$result = false;
		
		if ($code == '' && $XXX_I18n_Currencies['baseCurrency_code'] != '')
		{
			$code = $XXX_I18n_Currencies['baseCurrency_code'];
		}
		
		if (XXX_Array::hasKey($XXX_I18n_Currencies['information'], $code))
		{
			$result = $XXX_I18n_Currencies['information'][$code];
		}
		
		return $result;
	}
	
	public static function getExchangedAmount ($amount = 0, $to_currency_code = '', $from_currency_code = '', $exchangeRate = false)
	{
		if ($exchangeRate === false)
		{
			$exchangeRate = self::getExchangeRate($to_currency_code, $from_currency_code);
		}
		
		$amount *= $exchangeRate;
		
		return $amount;
	}
	
	public static function getExchangeRate ($to_code = '', $from_code = '', $canonical_code = '')
	{
		global $XXX_I18n_Currencies;
		
		if ($to_code == '' && $XXX_I18n_Currencies['baseCurrency_code'] != '')
		{
			$to_code = $XXX_I18n_Currencies['baseCurrency_code'];
		}
		
		if ($from_code == '' && $XXX_I18n_Currencies['baseCurrency_code'] != '')
		{
			$from_code = $XXX_I18n_Currencies['baseCurrency_code'];
		}
		
		if ($canonical_code == '' && $XXX_I18n_Currencies['canonicalCurrency_code'] != '')
		{
			$canonical_code = $XXX_I18n_Currencies['canonicalCurrency_code'];
		}
		
		$result = false;
		
		$foundResult = false;
		
		if ($to_code == $from_code)
		{
			$result = 1;
			
			$foundResult = true;
		}
		
		if (!$foundResult)
		{		
			// Try direct
			foreach ($XXX_I18n_Currencies['exchangeRates'] as $exchangeRate)
			{
				if ($exchangeRate['from_code'] == $from_code && $exchangeRate['to_code'] == $to_code)
				{
					$result = $exchangeRate['exchangeRate'];
					
					$foundResult = true;
					
					break;
				}
				else if ($exchangeRate['from_code'] == $to_code && $exchangeRate['to_code'] == $from_code)
				{
					$result = 1 / $exchangeRate['exchangeRate'];
					
					$foundResult = true;
					
					break;
				}
			}
			
			if (!$foundResult)
			{
				// Try with canonical as bridge
		
				if ($to_code != $canonical_code && $from_code != $canonical_code)
				{
					$foundCanonicalToToExchangeRate = false;
					$foundCanonicalToFromExchangeRate = false;
					
					$canonicalToToExchangeRate = 1;
					$canonicalToFromExchangeRate = 1;
					
					foreach ($XXX_I18n_Currencies['exchangeRates'] as $exchangeRate)
					{
						if ($exchangeRate['from_code'] == $canonical_code && $exchangeRate['to_code'] == $to_code)
						{
							$canonicalToToExchangeRate = $exchangeRate['exchangeRate'];
							
							$foundCanonicalToToExchangeRate = true;
							
							break;
						}
						else if ($exchangeRate['from_code'] == $to_code && $exchangeRate['to_code'] == $canonical_code)
						{
							$canonicalToToExchangeRate = 1 / $exchangeRate['exchangeRate'];
							
							$foundCanonicalToToExchangeRate = true;
							
							break;
						}
					}
					
					
					foreach ($XXX_I18n_Currencies['exchangeRates'] as $exchangeRate)
					{
						if ($exchangeRate['from_code'] == $canonical_code && $exchangeRate['to_code'] == $from_code)
						{
							$canonicalToFromExchangeRate = $exchangeRate['exchangeRate'];
							
							$foundCanonicalToFromExchangeRate = true;
							
							break;
						}
						else if ($exchangeRate['from_code'] == $from_code && $exchangeRate['to_code'] == $canonical_code)
						{
							$canonicalToFromExchangeRate = 1 / $exchangeRate['exchangeRate'];
							
							$foundCanonicalToFromExchangeRate = true;
							
							break;
						}
					}
					
					if ($foundCanonicalToToExchangeRate && $foundCanonicalToFromExchangeRate)
					{
						$result = (1 / $canonicalToFromExchangeRate) * $canonicalToToExchangeRate;
					}
				}
			}
		}
		
		return $result;
	}
	
	public static function getExchangeRatesExternal ($method = 'ecb')
	{
		$result = array();
				
		switch ($method)
		{
			case 'tmc':
				// TODO add courtesy link
				$xmlFileContent = XXX_FileSystem_Remote_HTTP::getFileContent('http://themoneyconverter.com/rss-feed/EUR/rss.xml');
				
				if ($xmlFileContent)
				{
					$patternMatches = XXX_String_Pattern::getMatches($xmlFileContent, '<title>([A-Z]{3})/([A-Z]{3})</title>.*?<description>1 Euro = ([0-9]+(?:\\.[0-9]+)?)', 'is');
					
					for ($i = 0, $iEnd = XXX_Array::getFirstLevelItemTotal($patternMatches[0]); $i < $iEnd; ++$i)
					{						
						$result[] = array
						(
							'from_code' => 'EUR',
							'to_code' => XXX_String::convertToUpperCase($patternMatches[1][$i]),
							'exchangeRate' => XXX_Type::makeFloat($patternMatches[3][$i])
						);
					}
				}
				break;
			case 'ecb':
			default:
				$xmlFileContent = XXX_FileSystem_Remote_HTTP::getFileContent('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml');
				
				if ($xmlFileContent)
				{
					$patternMatches = XXX_String_Pattern::getMatches($xmlFileContent, 'currency=["\']([a-z0-9]*)["\'] rate=["\']([0-9.]*)["\']', 'i');
					
					for ($i = 0, $iEnd = XXX_Array::getFirstLevelItemTotal($patternMatches[0]); $i < $iEnd; ++$i)
					{						
						$result[] = array
						(
							'from_code' => 'EUR',
							'to_code' => XXX_String::convertToUpperCase($patternMatches[1][$i]),
							'exchangeRate' => XXX_Type::makeFloat($patternMatches[2][$i])
						);
					}
				}	
				break;
		}
		
		return $result;
	}
}

?>