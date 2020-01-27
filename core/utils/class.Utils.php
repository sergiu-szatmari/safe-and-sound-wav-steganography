<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Utils
{
    public static function getHashFromFilename( $filename )
    {
        return str_replace(
            "steg_", 
            "", 
            str_replace(
                ".wav",
                "",
                $filename
            ));
    }
}