<?php

/**
 * This is the index.php
 *
 * It calls the View::render() method to determine the current page to
 * be displayed.
 */


require_once '../config.php';

$view = new View;
$view->render();

?>
