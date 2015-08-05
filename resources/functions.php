<?php

/**
 * Locate a file when given the relative path.
 * @return string|false $absolute_path
 */
function locate($relative_path)
{
    $absolute_path = SERVER_ROOT.'/'.$relative_path;
    if (file_exists($absolute_path)) {
        return $absolute_path;
    } else {
        return false;
    }
}

?>
