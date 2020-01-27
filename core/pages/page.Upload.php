<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Upload implements iPage
{
    public static function display( $stegFilename = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar();
        ?>
            <h1>Hash: <?php echo Utils::getHashFromFilename($stegFilename); ?></h1>
            <h3>Uploaded succesfully - setTimeout 2 secunde pana apare butonu de "Download is ready"</h3>
            <form action="index.php" method='POST' >
                <input type="hidden" name="action" value="download" />
                <?php
                if ( $stegFilename ) {
                    $inputElem = "<input type=\"hidden\" name=\"stegFilename\" value=\"$stegFilename\" />";
                    echo $inputElem;
                }
                ?>
                <input class="btn btn-default" type="submit" value="To download" />
            </form>
        <?php
        die;
    }
}