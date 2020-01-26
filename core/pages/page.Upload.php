<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Upload implements iPage
{
    public static function display( $downloadFilename = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar();
        ?>
            <span>Uploaded succesfully</span>
            <form action="index.php">
                <input type="hidden" name="action" value="download" />
                <?php
                if ( $downloadFilename ) {
                    $inputElem = "<input type=\"hidden\" name=\"name\" value=\"$downloadFilename\" />";
                    echo $inputElem;
                }
                ?>
                <input type="submit" value="To download" />
            </form>
        <?php
        die;
    }
}