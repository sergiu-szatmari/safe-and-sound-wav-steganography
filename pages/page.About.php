<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class About implements iPage
{
    public static function display()
    {
        ob_clean();

        ob_start();
        ?>

        <div class="about-container">
            <ul id="about-list">
                <li id="about-list-element">Some about text</li>
                <li id="about-list-element">Some other about text</li>
                <li id="about-list-element">Final about text?</li>
            </ul>
        </div>

        <form action="index.php">
            <input type="hidden" name="action" value="home" />
            <input type="submit" value="Home" />
        </form>
        <?php
        die;
    }
}