<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class SteganographyManager
{
    private static function execute( $command, $echoOutput = false )
    {
        exec( $command, $output, $return );

        if ( $echoOutput ) {
            echo 'Return status: ' . $return . '<br/>';
            foreach ( $output as $outputLine ) {
                echo $outputLine . '<br/>';
            }
        }

        if ( $return != 0 ) {
            throw new Exception('Command exec failed.');
        }
    }

    private static function moveFile( $filename )
    {
        $source         = Constants::_DIR_UPLOADS . $filename;
        $destination    = Constants::_DIR_EXTERNAL . $filename;

        if ( !copy($source, $destination) ) {
            throw new Exception('Preparing steganography process failed.');
        }
    }

    private static function prepare( $filename, $message )
    {
        # Moving file so the scripts can alter it
        self::moveFile( $filename );

        # Preparing the message
        self::execute( "cd external/ && echo $message > data.txt" ); 
    }

    private static function executeSteg( $filename )
    {
        $stegFilename = Constants::_STEG_FILE_PREFIX . $filename;
        self::execute( "cd external/ && call script.hide.bat data.txt $filename $stegFilename 2" );
    }

    public static function hide( $filename, $message )
    {
        self::prepare( $filename, $message );
        
        self::executeSteg( $filename );
    }

    public static function extract( $filename )
    {
        throw new Exception( __CLASS__ . '::' . __FUNCTION__ . ' not implemented.');
        // ...
    }
}