<?php
session_start();
require "inc/class.connectdb.php";
require "inc/class.session.php";

spl_autoload_register(function ($class_name) {
    $f = 'inc/class.' .  strtolower ($class_name) . '.php';
    if(file_exists($f)) {
        require $f;
    }
    else {
        echo "<pre>ERROR: Can not find $f</br>";
        debug_backtrace();
    }
});
