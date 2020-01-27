<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Upload implements iPage
{
    public static function display( $downloadFilename = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar();
        ?>
            <span>Uploaded succesfully - setTimeout 2 secunde pana apare butonu de "Download is ready"</span>
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