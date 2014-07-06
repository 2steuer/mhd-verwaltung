<?php

Email::set_mailer(
	new SmtpMailer()
);

//Required:
define('SMTPMAILER_SMTP_SERVER_ADDRESS', 'malteser-server.de'); //SMTP server address
define('SMTPMAILER_DO_AUTHENTICATE', true); //Turn on SMTP server authentication. Set to false for an anonymous connection
define('SMTPMAILER_USERNAME', 'noreply@malteser-stormarn.de'); //SMTP server username, if SMTPAUTH == true
define('SMTPMAILER_PASSWORD', 'MHD#noreply1'); //SMTP server password, if SMTPAUTH == true

//Optional:
define('SMTPMAILER_CHARSET_ENCODING', 'utf-8'); //Email characters encoding, e.g. : 'utf-8' or 'iso-8859-1'
define('SMTPMAILER_USE_SECURE_CONNECTION', 'ssl'); //SMTP encryption method : Set to '', 'tls', or 'ssl'
define('SMTPMAILER_SMTP_SERVER_PORT', 465); //SMTP server port. Set to 25 if no encryption is used, 465 if ssl or tls is activated
define('SMTPMAILER_DEBUG_MESSAGING_LEVEL', 0); //Print debugging informations. 0 = no debuging, 1 = print errors, 2 = print errors and messages, 4 = print full activity
define('SMTPMAILER_LANGUAGE_OF_MESSAGES', 'de'); //Language for messages. Look into smtp/code/vendor/language/ for available languages
define('SMTPMAILER_SEND_DELAY', 2000);//throttling, in milliseconds, can also be 0