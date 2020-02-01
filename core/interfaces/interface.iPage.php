<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

interface iPage
{
    public static function display( $action, $arg );
}