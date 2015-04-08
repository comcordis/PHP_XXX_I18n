<?php

XXX_Path_Local::addDefaultIncludePathsForPath('/XXX/XXX_Sources/YAT');

XXX_I18n_Localization::loadLocalization('us');
XXX_I18n_Translation::loadTranslation('en');

print_r(XXX_I18n_Translation::get('input', 'actions', 'value', 'operation', 'removePattern'));

//print_r(get_class_vars(XXX_I18n_Translation));

?>