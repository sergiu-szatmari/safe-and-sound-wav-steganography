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
            )
        );
    }

    public static function logObject( $object )
    {
        echo json_encode( $object, JSON_PRETTY_PRINT );
        echo '<br/>';
    }

    public static function logMessage( $message )
    {
        echo $message . '<br/>';
    }
}