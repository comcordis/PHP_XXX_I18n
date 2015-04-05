<?php

require_once 'XXX_I18n_UnitConverter.php';
require_once 'XXX_I18n_Formatter.php';
require_once 'XXX_I18n_Currency.php';
require_once 'XXX_I18n_Currencies.php';
require_once 'XXX_I18n_Translation.php';
require_once 'XXX_I18n_Localization.php';
require_once 'translations.php';
require_once 'localizations.php';

XXX_I18n_Currency::initialize();
XXX_I18n_Translation::initialize();
XXX_I18n_Localization::initialize();

XXX_Path_Local::addDefaultIncludePathsForProjectSource('XXX_I18n_PHP');

?>