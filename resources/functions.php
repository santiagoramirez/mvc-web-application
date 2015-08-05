<?php

/**
 * Locate a file from within the root directory.
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
