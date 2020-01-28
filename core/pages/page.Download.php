<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Download implements iPage
{
    public static function display( $stegFilename = null )
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
            <?php foreach ( $filenames as $file ): ?>
                <li class="list-group" style="text-align: center;"> 
                    <form action="index.php" method='POST'>
                        <input type="hidden" name="action" value="download">
                        <input type="hidden" name="stegFilename" value="<?php echo $file; ?>">
                        <input type="submit" value="<?php echo $file; ?>" class="btn btn-default" style="display: inline-block; width: 45vw; float: center; font-weight: bold;" >
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        </div>
        <?php
        
        Components::javascript( __CLASS__ );
        die;
    }
}