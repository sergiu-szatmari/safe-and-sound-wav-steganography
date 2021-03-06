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

    private static function prepare( $filename, $message = '' )
    {
        # Moving file so the scripts can alter it
        self::moveFile( $filename );

        # Preparing the message
        if ( !$message ) {
            $message = '""';
        }
        self::execute( "cd external/ && echo {$message} > data.txt" ); 
    }

    private static function executeStegHide( $filename )
    {
        $stegFilename = Constants::_STEG_FILE_PREFIX . $filename;
        self::execute( "cd external/ && call script.hide.bat data.txt $filename $stegFilename 2" );

        return $stegFilename;
    }

    private static function executeStegExtract( $filename )
    {
        self::execute( "cd external/ && call script.extract.bat $filename ./data.txt 2");
        return file_get_contents( Constants::_DIR_EXTERNAL . 'data.txt' );
    }

    private static function cleanUp( $filename )
    {
        $path = Constants::_DIR_EXTERNAL . $filename;
        if ( !unlink($path) ) {
            throw new Exception('Error in hide-cleanup process.');
        }

        $path = Constants::_DIR_EXTERNAL . 'data.txt';
        if ( !unlink($path) ) {
            throw new Exception('Error in hide-cleanup process.');
        }
    }

    public static function hide( $filename, $message )
    {
        self::prepare( $filename, $message );
        
        $stegFilename = self::executeStegHide( $filename );

        self::cleanUp( $filename );

        return $stegFilename;
    }

    public static function extract( $filename )
    {
        self::prepare( $filename, $message = '' );

        $message = self::executeStegExtract( $filename );

         self::cleanUp( $filename );

        return $message;
    }
}