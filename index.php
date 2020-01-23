<?php

define('_SAFE_AND_SOUND_VALID_ACCESS', 1);

try {

    require_once( __DIR__ . '/core/classes/class.Dispatcher.php');

    $dispatcher = new Dispatcher();
    $dispatcher->listen();

} catch (Exception $ex) {

    echo "500 Internal Server Error . . . ({$ex->getMessage()})";
    header('HTTP/1.1 500 Internal Server Error');
}