<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Download implements iPage
{
    public static function display( $action = null, $arg = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::css( __CLASS__ );
        Components::navbar( __CLASS__ );

        $filenames = FileManager::getStegFilenames();
        
        ?>
        <div class="downloads-container">
            <ul class="list-group">
                <?php
                    if (count($filenames) > 0):
                        foreach ( $filenames as $file ): ?>
                            <li class="list-group" style="text-align: center;">
                                <form action="index.php" method='POST'>
                                    <input type="hidden" name="action" value="download">
                                    <input type="hidden" name="stegFilename" value="<?= $file; ?>">
                                    <input type="submit" value="<?= $file; ?>" class="btn btn-default" style="display: inline-block; width: 45vw; font-weight: bold;" >
                                </form>
                            </li>
                <?php
                        endforeach;
                    else:
                ?>
                    <li class="list-group" style="text-align: center;" >
                        <h2>There are no files to download :(</h2>
                    </li>
                <?php
                    endif;
                ?>
            </ul>
        </div>
        <?php
        
        Components::javascript( __CLASS__ );
        die;
    }
}