<?php

/**
 * fungsi validasi hak akses berdasarkan level session
 */
function aksesOnly($level)
{
    if (is_array($level)) {
        if (!in_array($_SESSION['level'], $level)) {
            include_once('./pages/error/403.php');
            exit();
        }
    } else {
        if ($_SESSION['level'] != $level) {
            include_once('./pages/error/403.php');
            exit();
        }
    }
}
