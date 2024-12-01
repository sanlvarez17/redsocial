<?php

include_once "config/config.php";

include_once "helper/helper.php";

spl_autoload_register(function($file) {
    require_once "libs/" . $file . ".php";
});