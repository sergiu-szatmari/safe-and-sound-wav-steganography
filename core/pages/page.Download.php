<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Download implements iPage
{
    public static function display( $stegFilename = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar( __CLASS__ );

        ?>
            list of uploaded & steg-ed files => form POST -> onDownload
            ...
        <?php
    }
}