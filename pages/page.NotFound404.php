<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class NotFound404 implements iPage
{
    private static $unknownAction;
    
    public static function setUnknownAction( $unknownAction ) {
        self::$unknownAction = $unknownAction;
    }

    public static function display()
    {
        ?>
            <div class="notfound404-container">
                The requested action ("<?php echo self::$unknownAction; ?>") cannot be found.
            </div>
        <?php
        die;
    }
}