<?php


SS_Log::add_writer(new SS_LogFileWriter('sserrors.txt'), SS_Log::NOTICE, '<=');

global $project;
$project = 'mysite';

global $database;
$database = 'prueftermine';

// Set the site locale
i18n::set_locale('de_DE');
LocalDateHelper::setLocale('de_DE');
date_default_timezone_set('Europe/Berlin');

// Use _ss_environment.php file for configuration
require_once("conf/ConfigureFromEnv.php");