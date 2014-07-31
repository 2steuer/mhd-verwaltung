<?php

Director::set_environment_type('dev');
error_reporting(E_ALL);
SS_Log::add_writer(new SS_LogFileWriter('sserrors.txt'), SS_Log::NOTICE, '<=');

global $project;
$project = 'mysite';

global $databaseConfig;
$databaseConfig = array(
	"type" => 'MySQLDatabase',
	"server" => 'localhost',
	"username" => 'root',
	"password" => '',
	"database" => 'prueftermine',
	"path" => '',
);

// Set the site locale
i18n::set_locale('de_DE');
LocalDateHelper::setLocale('de_DE');
date_default_timezone_set('Europe/Berlin');