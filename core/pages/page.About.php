<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class About implements iPage
{
    public static function display( $action = null, $arg = null )
    {
        ob_clean();
        ob_start();

        Components::css( __CLASS__ );
        Components::bootstrap();
        Components::navbar( __CLASS__ );
        ?>
        <div class="about-container">

            <?php Components::textBlock(
                Components::pageContent( __CLASS__, 'safe-and-sound-about', 'title' ),
                Components::pageContent( __CLASS__, 'safe-and-sound-about', 'content' )
            ); ?>

            <?php Components::textBlock(
                Components::pageContent( __CLASS__, 'steganography-about', 'title'),
                Components::pageContent( __CLASS__, 'steganography-about', 'content')
            ); ?>

            <?php Components::textBlock(
                Components::pageContent( __CLASS__, 'lsb-about', 'title'),
                Components::pageContent( __CLASS__, 'lsb-about', 'content')
            ); ?>

        </div>
        <?php
        die;
    }
}