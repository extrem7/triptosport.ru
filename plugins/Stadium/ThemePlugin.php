<?php

/**
 * Plugin Name: Stadium
 * Version: 1.0
 * Author: YesTech
 * Author uri: https://t.me/drKeinakh
 */

require_once "includes/functions.php";
require_once "Stadium.php";

function ThemeActivation()
{
    global $Stadium;
    $Stadium = new Stadium();
}

ThemeActivation();