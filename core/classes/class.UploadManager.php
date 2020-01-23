<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class UploadManager
{
    private function checkRequirements()
    {
        if ( !file_exists(Path::_DIR_UPLOADS) ) {

            if ( !mkdir(Path::_DIR_UPLOADS) ) {
                throw new Exception('Cannot create "uploads" directory.');
            }
        }

        if ( !is_dir(Path::_DIR_UPLOADS) ) {
            throw new Exception('No directory found at "' . Path::_DIR_UPLOADS . '".');
        }

        if ( !$_FILES ) {
            throw new Exception('No file uploaded.');
        }

        // $_FILES is set
        // file does not exceed file size limit
    }

    private function initialize()
    {
        $this->checkRequirements();

    }

    public function manageUpload()
    {
        $this->initialize();

        $targetDestination = Path::_DIR_UPLOADS . $_POST['message'] . '_' . basename($_FILES['stegfile']['name']);

        return move_uploaded_file($_FILES['stegfile']['tmp_name'], $targetDestination) ?
            $targetDestination : 
            null;
    }
}