<?php

/**
 * This is the index.php
 *
 * It calls the View::render() method to determine the current page to
 * be displayed.
 *
 * @author Santiago Ramirez
 * @link http://santiagoramirez.net
 * @link https://github.com/santiagoramirez
 */

require_once '../resources/config.php';

$view = new View;
$view->render();

?>
