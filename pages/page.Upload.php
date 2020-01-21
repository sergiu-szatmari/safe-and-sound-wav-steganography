<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Upload implements iPage
{
    public static function display()
    {
        ?>
            <span>Uploaded succesfully</span>
            <form action="index.php">
                <input type="hidden" name="action" value="download" />
                <input type="hidden" name="key" value="some-hash" />
                <input type="submit" value="To download" />
            </form>
        <?php
        die;
    }
}