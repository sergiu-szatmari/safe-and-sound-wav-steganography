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
        Components::css( 'Upload' );
        ?>
        <div class="upload-page-hash">
            <h3>Server encountered an unexpected error . . . ("<?= ($errorMessage ?? ''); ?>")</h3>
        </div>
        <?php
        header('HTTP/1.1 500 Internal Server Error');
        die;
    }
}