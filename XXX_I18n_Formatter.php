<?php

abstract class XXX_I18n_Formatter
{
	////////////////////
	// RFC 2965
	////////////////////
	
	public static function formatRFC2965 ($timestamp)
	{
		return date('D, d-M-Y H:i:s T', $timestamp);
	}
	
	public static function formatRFC2822 ($timestamp = false)
	{
		if ($timestamp === false)
		{
			$timestamp = XXX_TimestampHelpers::getCurrentTimestamp();
		}
		
		$result = date(DATE_RFC2822, $timestamp);

		if ($result === false || empty($result))
		{
			$result = date('r', $timestamp);
		}

		if ($result === false || empty($result))
		{
			// Get timezone offset in seconds
			$timezoneOffset = date('Z', $timestamp);
			// Determine wether it's a negative or positive number
			$timezonePrefix = ($timezoneOffset < 0) ? "-" : "+";
			// Get the absolute number without prefixed - or +
			$timezoneOffset = abs($timezoneOffset);
			// Calculate the number of hours
			$timezoneOffset = ((($timezoneOffset / 3600) * 100) + (($timezoneOffset % 3600) / 60));
			// Construct the full date string
			$result = sprintf("%s %s%04d", date("D, j M Y H:i:s", $timestamp), $timezonePrefix, $timezoneOffset);
		}

		return $result;
	}
		
	public static function formatBytes ($bytes, $precision = 2)
	{ 
	    $units = array('B', 'KB', 'MB', 'GB', 'TB');
	
	    $bytes = max($bytes, 0); 
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	    $pow = min($pow, count($units) - 1);
	 
	    $bytes /= pow(1024, $pow);
	
	    return round($bytes, $precision) . ' ' . $units[$pow]; 
	} 
		
	public static function formatTimestamp ($timestamp = 0)
	{
		return date('D, d M Y @ H:i:s e', $timestamp);
	}
	
	public static function formatRelativeTimestamp ($relativeTimestamp = 0)
	{
		$absoluteTimestamp = XXX_TimestampHelpers::makeRelativeSecondTimestampAbsolute($relativeTimestamp);
		
		return date('D, d M Y @ H:i:s e', $absoluteTimestamp);
	}
	
	public static function formatRelativeMillisecondTimestamp ($relativeMillisecondTimestamp = 0)
	{
		$absoluteTimestamp = XXX_TimestampHelpers::makeRelativeSecondTimestampAbsolute(round($relativeMillisecondTimestamp / 1000));
		
		return date('D, d M Y @ H:i:s e', $absoluteTimestamp);
	}
	
	public static function formatElapsedTime ($time)
	{
		$now = XXX_TimestampHelpers::getCurrentSecondTimestamp();
	
		$difference = XXX_TimestampHelpers::getDifference($now - $time, $now);
				
		return ($difference['remainder']['day'].'d '.$difference['remainder']['hour'].'h '.$difference['remainder']['minute'].'m '.$difference['remainder']['second'].'s');
	}
	
	public static function formatCurrencyAmount ($amount = 0, $currency_code = 'EUR', $ceil = true)
	{
		$information = XXX_I18n_Currency::getInformation($currency_code);
		
		if ($ceil)
		{
			$amount = XXX_Number::ceil($amount);
		}
		else
		{
			$amount = XXX_Number::round($amount, $information['number']['decimals']);
		}
		
		$result = '';
		$result .= $information['symbol']['html'] . ' ' . $amount;
	
		return $result;
	}
}

?>