<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class About implements iPage
{
    public static function display( $action = null, $arg = null )
    {
        ob_clean();
        ob_start();

        Components::bootstrap();
        Components::navbar( __CLASS__ );
        ?>
        <div class="about-container">
            <ul id="about-list">
                <li id="about-list-element">Some about text</li>
                <li id="about-list-element">Some other about text</li>
                <li id="about-list-element">Final about text?</li>
            </ul>
        </div>
        <?php
        die;
    }
}