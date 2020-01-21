<?php

define('_SAFE_AND_SOUND_VALID_ACCESS', 1);

require_once('./core/classes/class.Dispatcher.php');

$dispatcher = new Dispatcher();
$dispatcher->listen();