<?php

/**
 * This is the config.php file.
 *
 * It requires all the files that are necessary to run our application
 * and defines commonly used constants.
 */

define('DB_NAME','');
define('DB_HOSTNAME', '');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('TABLE_PREFIX', '');

define('DOMAIN_ROOT', '');
define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);

define('MAINTENANCE_MODE', false);

require_once 'functions.php';

?>
