<?php

Director::set_environment_type('dev');
error_reporting(E_ALL);

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