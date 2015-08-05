<?php

/**
 * This is the config.php file.
 *
 * It requires all the files that are necessary to run our application
 * and defines commonly used constants.
 */

require_once 'functions.php';

define('DB_NAME','');

define('DB_HOSTNAME', '');

define('DB_USERNAME', '');

define('DB_PASSWORD', '');

define('TABLE_PREFIX', '');

define('DOMAIN_ROOT', '');

define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT']);

define('MAINTENANCE_MODE', false);

require_once locate('core/base-controller.php');
require_once locate('core/base-model.php');
require_once locate('core/base-view.php');
require_once locate('resources/classes/secure-session.php');
require_once locate('resources/libs/smarty/smarty.php');

?>
