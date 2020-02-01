<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Upload implements iPage
{
    public static function display( $action, $arg = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar();
        Components::css( __CLASS__ );
        switch ( $action ) {
            case 'hidden':
                ?>
                    <div class="upload-page-hash">
                        <h3>Your <i>SafeAndSound</i> hash: </h3>
                        <h2><?php echo Utils::getHashFromFilename($arg); ?></h2>
                    </div>

                    <div class="upload-page-buttons">
                        <form action="index.php" method='POST' >
                            <input type="hidden" name="action" value="download" />
                            <?php
                            if ( $arg ) {
                                $inputElem = "<input type=\"hidden\" name=\"stegFilename\" value=\"$arg\" />";
                                echo $inputElem;
                            }
                            ?>
                            <input class="hidden btn btn-default" type="submit" value="Download" />
                        </form>

                        <form action="index.php" method='GET'>
                            <input class="hidden btn btn-default" type="submit" value="Home">
                        </form>
                    </div>
                <?php
                break;

            case 'extracted':
                ?>
                    <div class="upload-page-hash">
                        <h3>The message hidden in the file: <?php echo $arg; ?></h3>
                    </div>
                    <div class="upload-page-buttons">
                        <form action="index.php" method='GET'>
                            <input class="hidden btn btn-default" type="submit" value="Home">
                        </form>
                    </div>
                <?php
                break;
        }

        Components::javascript( __CLASS__ );
        die;
    }
}