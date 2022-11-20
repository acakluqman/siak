<?php

if (!function_exists('secure_input')) {
    function secureInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        // $input = htmlspecialchars($input, ENT_QUOTES, "UTF-8");

        return $input;
    }
}
