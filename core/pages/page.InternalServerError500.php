<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class InternalServerError500 implements iPage
{
    public static function display( $action = null, $errorMessage = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar();
        ?>
        <div class="internal-server-error-container">
            <span> Server encountered an unexpected error . . . <?php echo $errorMessage ?? ''; ?> </span>
        </div>
        <?php
        header('HTTP/1.1 500 Internal Server Error');
        die;
    }
}