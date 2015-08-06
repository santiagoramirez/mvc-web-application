<?php

/**
 * This is the config.php file.
 *
 * It requires all the files that are necessary to run our application
 * and defines commonly used constants.
 */

defined('DB_NAME')
    or define('DB_NAME','mvc_app');

defined('DB_HOSTNAME')
    or define('DB_HOSTNAME', 'localhost');

defined('DB_USERNAME')
    or define('DB_USERNAME', 'santiagoramirez');

defined('DB_PASSWORD')
    or define('DB_PASSWORD', 'somethingcomplex');

defined('TABLE_PREFIX')
    or define('TABLE_PREFIX', '');

defined('DOMAIN_ROOT')
    or define('DOMAIN_ROOT', 'http://localhost/mvc-web-application');

define('SERVER_ROOT')
    or define('SERVER_ROOT', $_SERVER['DOCUMENT_ROOT'].'/mvc-web-application');

defined('MAINTENANCE_MODE')
    or define('MAINTENANCE_MODE', false);

require_once 'functions.php';
require_once locate('core/base-controller.php');
require_once locate('core/base-model.php');
require_once locate('core/base-view.php');
require_once locate('resources/classes/secure-session.php');
require_once locate('resources/libs/smarty-3.1.27/smarty.php');


?>
