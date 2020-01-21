<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class InternalServerError500 implements iPage
{
    public static function display()
    {
        ?>
        <div class="internal-server-error-container">
            <span> Server encountered an unexpected error . . . </span>
        </div>
        <?php
        die;
    }
}