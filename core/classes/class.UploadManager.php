<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class UploadManager
{
    private const UPLOAD_DIR = 'uploads/';

    public function manageUpload()
    {
        $targetDestination = self::UPLOAD_DIR . $_POST['hide_message'] . '_' . basename($_FILES['upload_file']['name']);

        return move_uploaded_file($_FILES['upload_file']['tmp_name'], $targetDestination) ?
            $targetDestination : 
            null;
    }
}