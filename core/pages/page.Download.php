<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Download implements iPage
{
    public static function display()
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar( __CLASS__ );
        ?>
            Download ==> Coming soon. (download by hash)
            <br/>
            Please wait (loading) ==> AJAX Request ==> Download Button appears
        <?php
    }
}