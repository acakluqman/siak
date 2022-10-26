<?php

if (!function_exists('secure_input')) {
    function secureInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);

        return $input;
    }
}
