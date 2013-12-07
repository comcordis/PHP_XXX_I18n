<?php

global $XXX_I18n_Localizations;

	$XXX_I18n_Localizations['us']['number'] = array
	(
		'integer' => array
		(
			// , | .
			'groupingSymbol' => ',',
			
			// >= 0 digits | [>= 0 digits, >= 1 digits, >= 1 digits, ...] backwards
			'grouping' => 3,
			
			// 0 - ? - For leading zeros
			'zeroPadding' => 1
		),
		
		'decimal' => array
		(
			// , | .
			'decimalSymbol' => '.',
			
			// 0 | >= 1 | fraction (doubles as zeroPadding)
			'decimalHandling' => 2,
			
			'fractionDenominators' => array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16)
		),
		
		/*
		Format string with:
		- %number% = number
		*/
		
		'formats' => array
		(
		 	'fraction' => '(%numerator%/%denominator%)',
			'positive' => '%number%',
			'negative' => '(-%number%)'
		)
	);
	
	$XXX_I18n_Localizations['us']['currency'] = array
	(
		// The current one
		'currency_code' => 'usd',
		
		// name | symbol | code
		'identifierType' => 'symbol',
		
		'number' => array
		(
			'integer' => array
			(
			),
			
			'decimal' => array
			(
				'decimalHandling' => 3
			)
		),
		
		/*
		Format string with:
		- %amount% = amount
		- %identifier% = currency identifier
		*/
		
		'formats' => array
		(
			'currency' => '%identifier%%amount%'
		)
	);
	
	$XXX_I18n_Localizations['us']['dateTime'] = array
	(
		// Gregorian calendar
		
		/*
		Cardinal date: 1 2 3
		Ordinal date: 1st 2nd 3rd
		*/
		
		// 12 | 24
		'clockType' => 24,
				
		// x seconds
		'timeZoneSecondOffset' => 3600,
		
		// true | false
		'daylightSavingTime' => false,
		
		// monday | sunday
		'weekStart' => 'monday',
		
		/*
		Date format string with:
		- %year% = year: 2009
		- %yearShort% = year short: 09
		- %yearShortPadded% = year short padded: 09 (For example in year < 10)
		
		- %month% = month: 7
		- %monthPadded% = month padded: 07
		- %monthName% = month name: July
		- %monthAbbreviation% = month abbreviation: Jul
		
		- %date% = date: 5
		- %datePadded% = date padded: 05
		
		- %dayOfTheWeek% = dayOfTheWeek: 1
		- %dayOfTheWeekPadded% = dayOfTheWeek padded: 01
		- %dayOfTheWeekName% = dayOfTheWeek name: Monday
		- %dayOfTheWeekAbbreviation% = dayOfTheWeek abbreviation: Mon
		
		- %weekOfTheYear% = ISO weekOfTheYear: 3
		- %weekOfTheYearPadded% = ISO weekOfTheYear padded: 03
		
		Time format string with:
		- %hour% = hour: 7
		- %hourPadded% = hour padded: 07
		
		- %minute% = minute: 5
		- %minutePadded% = minute 05
		
		- %second% = second: 3
		- %secondPadded% = second padded: 03
		
		- %meridiemName% = ante or post meridiem name
		- %meridiemAbbreviation% = ante or post meridiem abbreviation
		
		- %daylightSavingTimeName% = whether daylight saving time is in effect name
		- %daylightSavingTimeAbbreviation% = whether daylight saving time is in effect abbreviation
		
		- %timestamp% = UNIX time stamp
		*/
		
		'formats' => array
		(
		 	'timePicker' => '%hourShortPadded%:%minutePadded% %meridiemAbbreviation%',
			'datePicker' => '%datePadded%/%monthName%/%year%',
			
			'timeShort' => '%hourShortPadded%:%minutePadded%%meridiemAbbreviation% %daylightSavingTimeAbbreviation%',
			'timeLong' => '%hourShortPadded%:%minutePadded%:%secondPadded%%meridiemAbbreviation% %daylightSavingTimeAbbreviation%',
			
			'dateShort' => '%datePadded%/%monthPadded%/%year%',
			'dateLong' => '%dayOfTheWeekAbbreviation%, %datePadded% %monthName% %year% (W%weekOfTheYearPadded%)',
			
			'dateTime' => '%time% @ %date%'
		)
	);
	
	$XXX_I18n_Localizations['us']['timeSpan'] = array
	(
		// name | symbol
		'identifierType' => 'name',
		
		// false | true
		'reversedOrder' => false,
		
		// true | false
		'omitEmptyUnit' => true,
		
		/*
		Format options:			
		0 none
		1 microsecond
		2 millisecond
		4 second
		8 minute
		16 hour
		32 day
		64 week
		128 month
		256 quarter
		512 year
		1024 lustrum
		2048 decade
		4096 century
		8192 millenium
		*/
		
		'formatOptions' => 15100,
		
		/*
		Format string with:			
		- %quantity% = quantity of the unit
		- %unit% = unit
		*/
				
		'formats' => array
		(
			'timeSpan' => '%quantity% %unit%'
		)
	);
	
	$XXX_I18n_Localizations['us']['bitAndByteSize'] = array
	(
		/*		
		Format string with:
		- %quantity% = quantity
		- %unit% = unit
		*/
		
		'transfer' => array
		(
			// bit | byte
			'system' => 'bit',
			// decimal | binary
			'quantifierType' => 'binary',
			// name | symbol
			'identifierType' => 'symbol',
			// Format string
			'format' => '%quantity% %unit%'
		),
		
		'storage' => array
		(
			// bit | byte
			'system' => 'byte',
			// decimal | binary
			'quantifierType' => 'binary',
			// name | symbol
			'identifierType' => 'symbol',
			// Format string
			'format' => '%quantity% %unit%'
		)
	);
	
	$XXX_I18n_Localizations['us']['bodyWeight'] = array
	(
		/*
		pounds use fractions
		*/
	 	
		'number' => array
		(
			'decimal' => array
			(
				// 0 | >= 1 | fraction (doubles as zeroPadding)
				'decimalHandling' => 'fraction'
			)
		),
		
		/*
		Format string with:
		- %kilogram% = number of kilograms
		- %kilogramPadded% = number of kilograms padded
		- %kilogramIdentifier% = kilogram name or symbol
		
		- %pound% = number of pounds
		- %poundPadded% = number of pounds padded
		- %poundIdentifier% = pound name or symbol
		
		- %stone% = number of stones
		- %stonePadded% = number of stones padded
		- %stoneIdentifier% = stone name or symbol
		*/
		
		// kilogram | pound | stone
		'system' => 'stone',
		
		// name | symbol
		'identifierType' => 'symbol',
		
		// true | false
		'omitEmptyUnit' => true,
		
		'formats' => array
		(
			'pound' => '%pound%%poundIdentifier%',
			'stone' => '%stone%%stoneIdentifier% %pound%%poundIdentifier%',
			'kilogram' => '%kilogramPadded%%kilogramIdentifier%'
		)
	);
	
	$XXX_I18n_Localizations['us']['bodyLength'] = array
	(
		'number' => array
		(
			'decimal' => array
			(
				// 0 | >= 1 | fraction (doubles as zeroPadding)
				'decimalHandling' => 'fraction'
			)
		),
		
		/*
		Format string with:
		- %centimeter% = number of centimeters
		- %centimeterPadded% = number of centimeters padded
		- %centimeterIdentifier% = centimeter name or symbol
		
		- %meter% = number of meters
		- %meterPadded% = number of meters padded
		- %meterIdentifier% = meter name or symbol
		
		- %inch% = number of inches
		- %inchPadded% = number of inches padded
		- %inchIdentifier% = inch name or symbol
		
		- %foot% = number of feet
		- %footPadded% = number of feet padded
		- %footIdentifier% = foot name or symbol
		*/
		
		// centimeter | inch
		'system' => 'inch',
				
		// name | symbol
		'identifierType' => 'symbol',
				
		// true | false
		'omitEmptyUnit' => true,
				
		'formats' => array
		(
			'inchShort' => '%inch%%inchIdentifier%',
			'inchLong' => '%foot%%footIdentifier% %inch%%inchIdentifier%',
			
			'centimeterShort' => '%centimeterPadded%%centimeterIdentifier%',
			'centimeterLong' => '%meter%%meterIdentifier% %centimeterPadded%%centimeterIdentifier%'
		)
	);
	
	$XXX_I18n_Localizations['us']['distance'] = array
	(
		'number' => array
		(
			'decimal' => array
			(
				// 0 | >= 1 | fraction (doubles as zeroPadding)
				'decimalHandling' => 3
			)
		),
		
		/*
		Format string with:
		- %kilometer% = number of kilometers
		- %kilometerPadded% = number of kilometers padded
		- %kilometerIdentifier% = kilometer name or symbol
		
		- %mile% = number of miles
		- %milePadded% = number of miles padded
		- %mileIdentifier% = mile name or symbol
		*/
		
		// kilometer | mile
		'system' => 'kilometer',
		
		// name | symbol
		'identifierType' => 'symbol',
		
				
		// true | false
		'omitEmptyUnit' => true,
		
		'formats' => array
		(
			'kilometer' => '%kilometer%%kilometerIdentifier%',
			'mile' => '%mile%%mileIdentifier%'
		)
	);
	
	$XXX_I18n_Localizations['us']['coordinate'] = array
	(
		'number' => array
		(
			'decimal' => array
			(
				// 0 | >= 1 | fraction (doubles as zeroPadding)
				'decimalHandling' => 4
			)
		),
		
		// degree | degreeMinute | degreeMinuteSecond
		'system' => 'degreeMinuteSecond',
		
		'omitEmptyUnit' => false,
		
		// name | symbol
		'identifierType' => 'symbol',
		
		/*
		Format string with:
		- %degree% = number of degrees
		- %degreePadded% = number of degrees padded
		- %degreeIdentifier% = degree unit
		
		- %minute% = number of minutes
		- %minutePadded% = number of minutes padded
		- %minuteIdentifier% = minute unit
		
		- %second% = number of seconds
		- %secondPadded% = number of seconds padded
		- %secondIdentifier% = second unit
		*/
		
		// Format string
		'formats' => array
		(
			'location' => '%degree%%degreeIdentifier% %minute%%minuteIdentifier% %second%%secondIdentifier%'
		)
	);
	
	$XXX_I18n_Localizations['us']['temperature'] = array
	(
		'number' => array
		(
			'decimal' => array
			(
				// 0 | >= 1 | fraction (doubles as zeroPadding)
				'decimalHandling' => 1
			)
		),
		
		// celsius | fahrenheit | kelvin
		'system' => 'fahrenheit',
		
		// name | symbol
		'identifierType' => 'symbol',
		
		/*
		Format string with:
		- %degree% = number of degrees
		- %degreePadded% = number of degrees padded
		- %degreeIdentifier% = degree unit
		*/
		
		// Format string
		'formats' => array
		(
			'temperature' => '%degree%%degreeIdentifier%'
		)
	);
	
?>