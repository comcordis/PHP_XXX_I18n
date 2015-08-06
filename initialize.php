<?php

require_once 'XXX_I18n_UnitConverter.php';
require_once 'XXX_I18n_Formatter.php';
require_once 'XXX_I18n_Currency.php';
require_once 'XXX_I18n_Currencies.php';
require_once 'XXX_I18n_Translation.php';
require_once 'XXX_I18n_Localization.php';
require_once 'translations.php';
require_once 'localizations.php';

XXX_I18n_Currency::initialize(); // checkt de aanwezigheid van cache files op de Comcordis_Static en laadt die in het werkgeheugen
XXX_I18n_Translation::initialize(); // checkt de aanwezigheid van cache files op de Comcordis_Static en laadt die in het werkgeheugen
XXX_I18n_Localization::initialize(); // checkt de aanwezigheid van cache files op de Comcordis_Static en laadt die in het werkgeheugen

XXX_Path_Local::addDefaultIncludePathsForProjectSource('XXX_I18n_PHP'); // voegt deze map in de static toe aan de project source mappen, voor bijvoorbeeld de URI print in HTML-templates.
