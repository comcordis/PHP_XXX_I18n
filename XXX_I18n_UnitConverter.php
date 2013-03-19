<?php

abstract class XXX_I18n_UnitConverter
{
	////////////////////
	// PHP Configuration
	////////////////////
	
	public static function shortHandSizeConfigurationToBytes ($value)
	{
		$value = trim($value);
			
		$last = strtolower($value[strlen($value) - 1]);
		
		switch($last)
		{
			case 'g':
				$value *= 1073741824;
				break;
			case 'm':
				$value *= 1048576;
				break;
			case 'k':
				$value *= 1024;
				break;
			default:
				$value = XXX_Type::makeInteger($value);
				break;
		}
	
		return $value;
	}
	
	public static function booleanConfigurationToBoolean ($configurationOptionSwitchValue = '')
	{
		$configurationOptionSwitchValue = strtolower($configurationOptionSwitchValue);
		
		$configurationOptionSwitchValue = ($configurationOptionSwitchValue == 'on' || $configurationOptionSwitchValue == '1' || $configurationOptionSwitchValue == 'true');
		
		return ($configurationOptionSwitchValue ? true : false);
	}
	
	////////////////////
	// Length / Distance
	////////////////////
	
	/*
	Canonical form: centimeter
	
	1 in = 2.54 cm
	
	thou/mil/point [0.001 in]
	inch (in/") [2.54 cm] 
	foot (ft/') [12 in]
	yard (yd) [36 in]
	furlong (fur) [7920 in]
	mile (mi) [63360 in]
	
	millimeter (mm) [0.1 cm]
	decimeter (dm) [10 cm]
	centimeter (cm) [1 cm]
	meter (m) [100 cm]
	kilometer (km) [100000 cm]
	
	
	cm are decimal
	inch are fraction 1/4 11/ 3/4
	
	*/
	
	public static function centimeterToThou ($centimeter = 0)
	{
		return self::centimeterToInch($centimeter) * 1000;
	}
	
	public static function centimeterToMil ($centimeter = 0)
	{
		return self::centimeterToThou($centimeter);
	}
	
	public static function centimeterToPoint ($centimeter = 0)
	{
		return self::centimeterToThou($centimeter);
	}
	
	public static function centimeterToInch ($centimeter = 0)
	{
		return $centimeter / 2.54;
	}
	
	public static function centimeterToFoot ($centimeter = 0)
	{
		return self::centimeterToInch($centimeter) / 12;
	}
	
	public static function centimeterToYard ($centimeter = 0)
	{
		return self::centimeterToInch($centimeter) / 36;
	}
	
	public static function centimeterToFurlong ($centimeter = 0)
	{
		return self::centimeterToInch($centimeter) / 7920;
	}
	
	public static function centimeterToMile ($centimeter = 0)
	{
		return self::centimeterToInch($centimeter) / 63360;
	}
	
	
	public static function thouToCentimeter ($thou = 0)
	{
		return self::inchToCentimeter($thou / 1000);
	}
	
	public static function milToCentimer ($mil = 0)
	{
		return self::thouToCentimeter($mil);
	}
	
	public static function pointToCentimer ($point = 0)
	{
		return self::thouToCentimeter($point);
	}
	
	public static function inchToCentimeter ($inch = 0)
	{
		return $inch * 2.54;
	}
	
	public static function footToCentimeter ($foot = 0)
	{
		return self::inchToCentimeter($foot * 12);
	}
	
	public static function yardToCentimeter ($yard = 0)
	{
		return self::inchToCentimeter($yard * 36);
	}
	
	public static function furlongToCentimeter ($furlong = 0)
	{
		return self::inchToCentimeter($furlong * 7920);
	}
	
	public static function mileToCentimeter ($mile = 0)
	{
		return self::inchToCentimeter($mile * 63360);
	}
	
	
	public static function centimeterToMillimeter ($centimeter = 0)
	{
		return $centimeter * 10;
	}
	
	public static function centimeterToDecimeter ($centimeter = 0)
	{
		return $centimeter / 10;
	}
	
	public static function centimeterToMeter ($centimeter = 0)
	{
		return $centimeter / 100;
	}
	
	public static function centimeterToKilometer ($centimeter = 0)
	{
		return $centimeter / 10000;
	}
	
	
	public static function millimeterToCentimeter ($millimeter = 0)
	{
		return $millimeter / 10;
	}
	
	public static function decimeterToCentimeter ($decimeter = 0)
	{
		return $decimeter * 10;
	}
	
	public static function meterToCentimeter ($meter = 0)
	{
		return $meter * 100;
	}
	
	public static function kilometerToCentimeter ($kilometer = 0)
	{
		return $kilometer * 10000;
	}
	
	
	////////////////////
	// Mass / Weight
	////////////////////
	
	/*
	Canonical form: kilogram
	
	pounds (Avoirdupois)
	
	1 kilogram = 2.20462262 pounds
	1 pound = 0.45359237 kilograms
		
	ounce (oz) [1/16 lb]
	pound (lb) [0.45359237 kg]
	stone (st) [14 lb]
	
	gram (g) [0.001 kg]
	
	kilogram (kg) [1 kg]
	*/
	
	public static function kilogramToPound ($kilogram = 0)
	{
		return $kilogram * 2.20462262;
	}
	
	public static function kilogramToOunce ($kilogram = 0)
	{
		return self::kilogramToPound($kilogram) * 16;
	}
	
	public static function kilogramToStone ($kilogram = 0)
	{
		return self::kilogramToPound($kilogram) / 14;
	}
	
	
	public static function poundToKilogram ($pound = 0)
	{
		return $pound * 0.45359237;
	}
	
	public static function ounceToKilogram ($ounce = 0)
	{
		return self::poundToKilogram($ounce / 16);
	}
	
	public static function stoneToKilogram ($stone = 0)
	{
		return self::poundToKilogram($stone * 14);
	}
	
	
	public static function kilogramToGram ($kilogram = 0)
	{
		return $kilogram * 1000;
	}
	
	public static function gramToKilogram ($gram = 0)
	{
		return $gram / 1000;
	}
	
	
	////////////////////
	// Time
	////////////////////
	
	/*
	Canonical form: second
	
	second (s) [1 s]
	
	microsecond (us) [0.000.001 s]
	millisecond (ms) [0.001 s]
	minute (m) [60 s]
	hour (h) [3600 s]
	day (d) [86400 s]
	week (w) [604800 s] (7 days)
	month (m) [2678400 s] (31 days)
	quarter (q) [7948800 s] (31 + 30 + 31 = 92 days)
	year (y) [31536000 s] (365 days)
	lustrum [157680000 s] (5 years)
	decade [315360000 s] (10 years)
	century [3153600000 s] (100 years)
	millenium [31536000000 s] (1000 years)
	*/
	
	public static function secondToMicrosecond ($second = 0)
	{
		return $second * 1000000;
	}
	
	public static function secondToMillisecond ($second = 0)
	{
		return $second * 1000;
	}
	
	public static function secondToMinute ($second = 0)
	{
		return $second / 60;
	}
	
	public static function secondToHour ($second = 0)
	{
		return $second / 3600;
	}
	
	public static function secondToDay ($second = 0)
	{
		return $second / 86400;
	}
	
	public static function secondToWeek ($second = 0)
	{
		return $second / 604800;
	}
	
	public static function secondToMonth ($second = 0)
	{
		return $second / 2678400;
	}
	
	public static function secondToQuarter ($second = 0)
	{
		return $second / 7948800;
	}
	
	public static function secondToYear ($second = 0)
	{
		return $second / 31536000;
	}
	
	public static function secondToLustrum ($second = 0)
	{
		return $second / 157680000;
	}
	
	public static function secondToDecade ($second = 0)
	{
		return $second / 315360000;
	}
	
	public static function secondToCentury ($second = 0)
	{
		return $second / 3153600000;
	}
	
	public static function secondToMillenium ($second = 0)
	{
		return $second / 31536000000;
	}
	
	
	
	public static function microsecondToSecond ($microsecond = 0)
	{
		return $microsecond / 1000000;
	}
	
	public static function millisecondToSecond ($millisecond = 0)
	{
		return $millisecond / 1000;
	}
	
	public static function minuteToSecond ($minute = 0)
	{
		return $minute * 60;
	}
	
	public static function hourToSecond ($hour = 0)
	{
		return $hour * 3600;
	}
	
	public static function dayToSecond ($day = 0)
	{
		return $day * 86400;
	}
	
	public static function weekToSecond ($week = 0)
	{
		return $week * 604800;
	}
	
	public static function monthToSecond ($month = 0)
	{
		return $month * 2678400;
	}
	
	public static function quarterToSecond ($quarter = 0)
	{
		return $quarter * 7948800;
	}
	
	public static function yearToSecond ($year = 0)
	{
		return $year * 31536000;
	}
	
	public static function lustrumToSecond ($lustrum = 0)
	{
		return $lustrum * 157680000;
	}
	
	public static function decadeToSecond ($decade = 0)
	{
		return $decade * 315360000;
	}
	
	public static function centuryToSecond ($century = 0)
	{
		return $century * 3153600000;
	}
	
	public static function milleniumToSecond ($millenium = 0)
	{
		return $millenium * 31536000000;
	}
	
	////////////////////
	// Bit & Byte (Storage & Transfer)
	////////////////////
	
	/*
	Canonical form: byte
		
	kilo (k) [1000]
	mega (M) [1000000]
	giga (G) [1000000000]
	tera (T) [1000000000000]
	peta (P) [1000000000000000]
	exa (E) [1000000000000000000]
	zetta (Z) [1000000000000000000000]
	yotta (Y) [1000000000000000000000000]
	
	kibi (Ki) [1024]
	mebi (Mi) [1048576]
	gibi (Gi) [1073741824]
	tebi (Ti) [1099511627776]
	pebi (Pi) [1125899906842624]
	exbi (Ei) [1152921504606846976]
	zebi (Zi) [1180591620717411303424]
	yobi (Yi) [1208925819614629174706176]
	
	bit (b) [1]
	byte (B) [8]
	
	*/
	
	public static function bitToKilobit ($bit = 0)
	{
		return $bit / 1000;
	}
	
	public static function bitToMegabit ($bit = 0)
	{
		return $bit / 1000000;
	}
	
	public static function bitToGigabit ($bit = 0)
	{
		return $bit / 1000000000;
	}
	
	public static function bitToTerabit ($bit = 0)
	{
		return $bit / 1000000000000;
	}
	
	public static function bitToPetabit ($bit = 0)
	{
		return $bit / 1000000000000000;
	}
	
	public static function bitToExabit ($bit = 0)
	{
		return $bit / 1000000000000000000;
	}
	
	public static function bitToZettabit ($bit = 0)
	{
		return $bit / 1000000000000000000000;
	}
	
	public static function bitToYottabit ($bit = 0)
	{
		return $bit / 1000000000000000000000000;
	}
	
	
	
	public static function bitToKibibit ($bit = 0)
	{
		return $bit / 1024;
	}
	
	public static function bitToMebibit ($bit = 0)
	{
		return $bit / 1048576;
	}
	
	public static function bitToGibibit ($bit = 0)
	{
		return $bit / 1073741824;
	}
	
	public static function bitToTebibit ($bit = 0)
	{
		return $bit / 1099511627776;
	}
	
	public static function bitToPebibit ($bit = 0)
	{
		return $bit / 1125899906842624;
	}
	
	public static function bitToExbibit ($bit = 0)
	{
		return $bit / 1152921504606846976;
	}
	
	public static function bitToZebibit ($bit = 0)
	{
		return $bit / 1180591620717411303424;
	}
	
	public static function bitToYobibit ($bit = 0)
	{
		return $bit / 1208925819614629174706176;
	}
	
	
		
	public static function kilobitToBit ($kilobit = 0)
	{
		return $kilobit * 1000;
	}
	
	public static function megabitToBit ($megabit = 0)
	{
		return $megabit * 1000000;
	}
	
	public static function gigabitToBit ($gigabit = 0)
	{
		return $gigabit * 1000000000;
	}
	
	public static function terabitToBit ($terabit = 0)
	{
		return $terabit * 1000000000000;
	}
	
	public static function petabitToBit ($petabit = 0)
	{
		return $petabit * 1000000000000000;
	}
	
	public static function exabitToBit ($exabit = 0)
	{
		return $exabit * 1000000000000000000;
	}
	
	public static function zettabitToBit ($zettabit = 0)
	{
		return $zettabit * 1000000000000000000000;
	}
	
	public static function yottabitToBit ($yottabit = 0)
	{
		return $yottabit * 1000000000000000000000000;
	}
	
	
	
	public static function kibibitToBit ($kibibit = 0)
	{
		return $kibibit * 1024;
	}
	
	public static function mebibitToBit ($mebibit = 0)
	{
		return $mebibit * 1048576;
	}
	
	public static function gibibitToBit ($gibibit = 0)
	{
		return $gibibit * 1073741824;
	}
	
	public static function tebibitToBit ($tebibit = 0)
	{
		return $tebibit * 1099511627776;
	}
	
	public static function pebibitToBit ($pebibit = 0)
	{
		return $pebibit * 1125899906842624;
	}
	
	public static function exbibitToBit ($exbibit = 0)
	{
		return $exbibit * 1152921504606846976;
	}
	
	public static function zebibitToBit ($zebibit = 0)
	{
		return $zebibit * 1180591620717411303424;
	}
	
	public static function yobibitToBit ($yobibit = 0)
	{
		return $yobibit * 1208925819614629174706176;
	}
	
	// bytes instead of byte to be consistent with clientSide
	
	public static function byteToKilobyte ($bytes = 0)
	{
		return $bytes / 1000;
	}
	
	public static function byteToMegabyte ($bytes = 0)
	{
		return $bytes / 1000000;
	}
	
	public static function byteToGigabyte ($bytes = 0)
	{
		return $bytes / 1000000000;
	}
	
	public static function byteToTerabyte ($bytes = 0)
	{
		return $bytes / 1000000000000;
	}
	
	public static function byteToPetabyte ($bytes = 0)
	{
		return $bytes / 1000000000000000;
	}
	
	public static function byteToExabyte ($bytes = 0)
	{
		return $bytes / 1000000000000000000;
	}
	
	public static function byteToZettabyte ($bytes = 0)
	{
		return $bytes / 1000000000000000000000;
	}
	
	public static function byteToYottabyte ($bytes = 0)
	{
		return $bytes / 1000000000000000000000000;
	}
	
	
	
	public static function byteToKibibyte ($bytes = 0)
	{
		return $bytes / 1024;
	}
	
	public static function byteToMebibyte ($bytes = 0)
	{
		return $bytes / 1048576;
	}
	
	public static function byteToGibibyte ($bytes = 0)
	{
		return $bytes / 1073741824;
	}
	
	public static function byteToTebibyte ($bytes = 0)
	{
		return $bytes / 1099511627776;
	}
	
	public static function byteToPebibyte ($bytes = 0)
	{
		return $bytes / 1125899906842624;
	}
	
	public static function byteToExbibyte ($bytes = 0)
	{
		return $bytes / 1152921504606846976;
	}
	
	public static function byteToZebibyte ($bytes = 0)
	{
		return $bytes / 1180591620717411303424;
	}
	
	public static function byteToYobibyte ($bytes = 0)
	{
		return $bytes / 1208925819614629174706176;
	}
	
		
		
	public static function kilobyteToByte ($kilobyte = 0)
	{
		return $kilobyte * 1000;
	}
	
	public static function megabyteToByte ($megabyte = 0)
	{
		return $megabyte * 1000000;
	}
	
	public static function gigabyteToByte ($gigabyte = 0)
	{
		return $gigabyte * 1000000000;
	}
	
	public static function terabyteToByte ($terabyte = 0)
	{
		return $terabyte * 1000000000000;
	}
	
	public static function petabyteToByte($petabyte = 0)
	{
		return $petabyte * 1000000000000000;
	}
	
	public static function exabyteToByte ($exabyte = 0)
	{
		return $exabyte * 1000000000000000000;
	}
	
	public static function zettabyteToByte ($zettabyte = 0)
	{
		return $zettabyte * 1000000000000000000000;
	}
	
	public static function yottabyteToByte ($yottabyte = 0)
	{
		return $yottabyte * 1000000000000000000000000;
	}
	
	
	
	public static function kibibyteToByte ($kibibyte = 0)
	{
		return $kibibyte * 1024;
	}
	
	public static function mebibyteToByte ($mebibyte = 0)
	{
		return $mebibyte * 1048576;
	}
	
	public static function gibibyteToByte ($gibibyte = 0)
	{
		return $gibibyte * 1073741824;
	}
	
	public static function tebibyteToByte ($tebibyte = 0)
	{
		return $tebibyte * 1099511627776;
	}
	
	public static function pebibyteToByte ($pebibyte = 0)
	{
		return $pebibyte * 1125899906842624;
	}
	
	public static function exbibyteToByte ($exbibyte = 0)
	{
		return $exbibyte * 1152921504606846976;
	}
	
	public static function zebibyteToByte ($zebibyte = 0)
	{
		return $zebibyte * 1180591620717411303424;
	}
	
	public static function yobibyteToByte ($yobibyte = 0)
	{
		return $yobibyte * 1208925819614629174706176;
	}
	
	
	
	public static function bitToByte ($bit = 0)
	{
		return $bit / 8;
	}
	
	// bytes instead of byte to be consistent with clientSide
	
	public static function byteToBit ($bytes = 0)
	{
		return $bytes * 8;
	}
			
	////////////////////
	// Currency
	////////////////////
	
	/*
	Canonical form: credit
	
	credit (cr) [1 cr]
	
	euro (eur) [1000 cr]
	*/
	
	public static function creditToEuro ($credit = 0)
	{
		return $credit / 1000;
	}
	
	public static function creditToCurrency ($credit = 0, $currency_code = 'eur')
	{
		if (!$currency_code)
		{
			$currency_code = XXX_I18n_Localization::get('currency', 'currency_code');
		}
		
		return self::creditToEuro($credit) * XXX_I18n_Currency::$exchangeRates[$currency_code];
	}
	
	public static function euroToCredit ($euro = 0)
	{
		return $euro * 1000;
	}
	
	public static function currencyToCredit ($currency = 0, $currency_code = 'eur')
	{
		if (!$currency_code)
		{
			$currency_code = XXX_I18n_Localization::get('currency', 'currency_code');
		}
		
		return self::euroToCredit($currency / XXX_I18n_Currency::$exchangeRates[$currency_code]);
	}
	
	////////////////////
	// Temperature
	////////////////////
	
	/*
	Canonical form: celsius
	
	celsius (C) [1 c]
	
	fahrenheit (F)
	kelvin (K)
	*/
		
	public static function celsiusToFahrenheit ($celsius = 0)
	{
		return (212 - 32) / 100 * $celsius + 32;
	}
	
	public static function celsiusToKelvin ($celsius = 0)
	{
		return $celsius + 273;
	}
	
	
	
	public static function fahrenheitToCelsius ($fahrenheit = 0)
	{
		return 100 / (212 - 32) * ($fahrenheit - 32);
	}
	
	public static function kelvinToCelsius ($kelvin = 0)
	{
		return $kelvin - 273;
	}
	
	////////////////////
	// Coordinates
	////////////////////
	
	/*
	
	Canonical form: decimalCoordinate
	
	Latitude: vertical (South -90 - 90 North)
	Longitude: horizontal (West -180 - 180 East)
	
	degree: ° 
	minute: ' (0 - 59) [1/60 degree]
	second: " (0 - 59) [1/60 minute]
		
	*/
	
	public static function decimalCoordinateToDegreeMinuteSecondCoordinate ($decimalCoordinate = 0)
	{
		$result = array
		(
			'degree' => 0,
			'minute' => 0,
			'second' => 0
		);
		
		$isPositive = $decimalCoordinate >= 0;
		
		$decimalCoordinate = XXX_Number::absolute($decimalCoordinate);
		
		$result['degree'] = XXX_Number::floor($decimalCoordinate);
		
		$decimalCoordinate -= $result['degree'];
		$decimalCoordinate *= 60;		
		$result['minute'] = XXX_Number::floor($decimalCoordinate);
		
		$decimalCoordinate -= $result['minute'];		
		$decimalCoordinate *= 60;		
		$result['second'] = $decimalCoordinate;
		
		if (!$isPositive)
		{
			$result['degree'] *= -1;
		}
		
		return $result;
	}
	
	public static function decimalCoordinateToDegreeMinuteCoordinate ($decimalCoordinate = 0)
	{
		$result = array
		(
			'degree' => 0,
			'minute' => 0
		);
		
		$isPositive = $decimalCoordinate >= 0;
		
		$decimalCoordinate = XXX_Number::absolute($decimalCoordinate);
		
		$result['degree'] = XXX_Number::floor($decimalCoordinate);
				
		$decimalCoordinate -= $result['degree'];
		$decimalCoordinate *= 60;
		$result['minute'] = $decimalCoordinate;
		
		if (!$isPositive)
		{
			$result['degree'] *= -1;
		}
		
		return $result;
	}
	
	public static function degreeMinuteSecondCoordinateToDecimalCoordinate ($degreeMinuteSecondCoordinate = array('degree' => 0, 'minute' => 0, 'second' => 0))
	{
		$result = $degreeMinuteSecondCoordinate['degree'];
		
		$degreeMinuteSecondCoordinate['minute'] += $degreeMinuteSecondCoordinate['second'] / 60;
		
		if ($result >= 0)
		{
			$result += $degreeMinuteSecondCoordinate['minute'] / 60;
		}
		else
		{
			$result -= $degreeMinuteSecondCoordinate['minute'] / 60;
		}
		
		return $result;
	}
	
	public static function degreeMinuteCoordinateToDecimalCoordinate ($degreeMinuteCoordinate = array('degree' => 0, 'minute' => 0))
	{
		$result = $degreeMinuteSecondCoordinate['degree'];
				
		if ($result >= 0)
		{
			$result += $degreeMinuteSecondCoordinate['minute'] / 60;
		}
		else
		{
			$result -= $degreeMinuteSecondCoordinate['minute'] / 60;
		}
		
		return $result;
	}
	
	////////////////////
	// Decimal / Fraction
	////////////////////
	
	/*
	
	numerator: top number
	denominator: bottom number
	
	&#189; 1/2	
	
	&#8531; 1/3
	&#8532; 2/3
	
	&#188; 1/4
	&#190; 3/4
	
	&#8533; 1/5
	&#8534; 2/5
	&#8535; 3/5
	&#8536; 4/5
	
	&#8537; 1/6
	&#8538; 5/6
	
	&#8539; 1/8 
	&#8540; 3/8
	&#8541; 5/8
	&#8542; 7/8
	
	&#8528; 1/7
	&#8529; 1/9
	&#8530; 1/10
	
	&#8260; Fraction slash
	
	Super 
	&#8304; 0
	&#180; 1
	&#178; 2
	&#179; 3
	&#8308; 4
	&#8309; 5
	&#8310; 6
	&#8311; 7
	&#8312; 8
	&#8313; 9
	
	Sub
	&#8320; 0
	&#8321; 1
	&#8322; 2
	&#8323; 3
	&#8324; 4
	&#8325; 5
	&#8326; 6
	&#8327; 7
	&#8328; 8
	&#8329; 9
	
	*/
	
	public static function decimalToFraction ($decimal = 0, $allowedDenominators = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16))
	{
		$result = false;
				
		$allowedDenominatorsTotal = XXX_Array::getFirstLevelItemTotal($allowedDenominators);
		
		if ($allowedDenominatorsTotal)
		{
			$maximumDelta = 1 / $allowedDenominators[$allowedDenominatorsTotal - 1];
			
			for ($i = 0, $iEnd = $allowedDenominatorsTotal; $i < $iEnd; ++$i)
			{
				$allowedDenominator = $allowedDenominators[$i];
				
				$allowedNumeratorDecimal = 1 / $allowedDenominator;
				
				$closestNumeratorDecimalFloor = XXX_Number::floor($decimal / $allowedNumeratorDecimal) * $allowedNumeratorDecimal;
				$closestNumeratorDecimalCeil = XXX_Number::ceil($decimal / $allowedNumeratorDecimal) * $allowedNumeratorDecimal;
				
				$floorDelta = $decimal - $closestNumeratorDecimalFloor;
				$ceilDelta = $closestNumeratorDecimalCeil- $decimal;
				
				$floorNumerator = $closestNumeratorDecimalFloor / $allowedNumeratorDecimal;
				$ceilNumerator = $closestNumeratorDecimalCeil / $allowedNumeratorDecimal;
				
				if ($floorDelta <= $ceilDelta)
				{
					if ($floorDelta <= $maximumDelta)
					{
						$result = array
						(
							'numerator' => $floorNumerator,
							'denominator' => $allowedDenominator
						);	
						
						break;
					}
					else if ($ceilDelta <= $maximumDelta)
					{
						$result = array
						(
							'numerator' => $ceilNumerator,
							'denominator' => $allowedDenominator
						);
						
						break;
					}
				}
				else
				{
					if ($ceilDelta <= $maximumDelta)
					{
						$result = array
						(
							'numerator' => $ceilNumerator,
							'denominator' => $allowedDenominator
						);
						
						break;
					}
					else if ($floorDelta <= $maximumDelta)
					{
						$result = array
						(
							'numerator' => $floorNumerator,
							'denominator' => $allowedDenominator
						);
						
						break;
					}
				}
			}
		}
		
		return $result;
	}
	
	public static function fractionToDecimal ($fraction = array('numerator' => 0, 'denominator' => 0))
	{
		return (1 / $fraction['denominator']) * $fraction['numerator'];
	}
}

?>