<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class InternalServerError500 implements iPage
{
    public static function display( $errorMessage = null )
    {
        ob_clean();
        ob_start();
        
        ?>
        <div class="internal-server-error-container">
            <span> Server encountered an unexpected error . . . <?php echo $errorMessage ?? ''; ?> </span>
        </div>
        <?php
        header('HTTP/1.1 500 Internal Server Error');
        die;
    }
}