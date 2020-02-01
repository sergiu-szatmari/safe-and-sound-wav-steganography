<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class NotFound404 implements iPage
{
    private static $unknownAction;
    
    public static function setUnknownAction( $unknownAction ) 
    {
        self::$unknownAction = $unknownAction;
    }

    public static function display( $action = null, $arg = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar();
        ?>
            <div class="notfound404-container">
                The requested action ("<?php echo self::$unknownAction; ?>") cannot be found.
            </div>
        <?php
        header("HTTP/1.1 404 Not Found");
        die;
    }
}