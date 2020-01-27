<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class FileManager
{
    private static function checkRequirements()
    {
        if ( !file_exists(Constants::_DIR_UPLOADS) ) {
            if ( !mkdir(Constants::_DIR_UPLOADS) ) {
                throw new Exception('Cannot create "uploads/" directory.');
            }
        }

        if ( !is_dir(Constants::_DIR_UPLOADS) ) {
            throw new Exception('No directory found at "' . Constants::_DIR_UPLOADS . '".');
        }

        if ( !isset($_FILES['stegfile']) ) {
            throw new Exception('No file uploaded.');
        }

        if ( isset($_FILES['stegfile']['error']) and $_FILES['stegfile']['error'] ) {
            throw new Exception('Error encountered.');
        }

        if ( $_FILES['stegfile']['type'] !== Constants::_WAV_FILE_TYPE ) {
            throw new Exception('File is not .wav');
        }

        if ( $_FILES['stegfile']['size'] > Constants::_WAV_FILE_INT_MAX_SIZE_ALLOWED ) {
            throw new Exception('File exceeds max upload filesize allowed.');
        }

    }

    private static function upload()
    {
        $filenameHash   = sha1( basename( $_FILES['stegfile']['name']) );
        $newFilename    = $filenameHash . Constants::_WAV_EXTENSION;
        
        $source         = $_FILES['stegfile']['tmp_name'];
        $destination    = Constants::_DIR_UPLOADS . $newFilename;

        if ( !move_uploaded_file( $source, $destination ) ) {
            throw new Exception('Upload failed.');
        }
        
        return $newFilename;
    }

    public static function onUpload()
    {
        self::checkRequirements();

        $newFilename = self::upload();

        return $newFilename;
    }

    public static function onDownload( $stegFilename )
    {
        $stegFile = Constants::_DIR_EXTERNAL . $stegFilename;
        
        header('Content-Type: application/download');
        header('Content-Disposition: attachment; filename="' . $stegFilename . '"');
        header("Content-Length: " . filesize($stegFile));
    
        $fp = fopen( $stegFile, "r" );
        fpassthru($fp);
        fclose($fp);
        die;
    }
}