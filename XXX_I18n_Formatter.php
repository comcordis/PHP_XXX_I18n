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
}

?>