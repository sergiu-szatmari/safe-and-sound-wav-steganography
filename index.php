<?php

define('_SAFE_AND_SOUND_VALID_ACCESS', 1);

try {

    $essentials = [
        '/core/classes/class.Dispatcher.php',
        '/core/interfaces/interface.iPage.php',
        '/core/utils/class.Components.php',
        '/core/pages/page.InternalServerError500.php'
    ];

    foreach ( $essentials as $essential ) {
        require_once( __DIR__ . $essential );
    }

    Dispatcher::listen();

} catch (Exception $ex) {

    InternalServerError500::display( $action = null, $errorMessage = $ex->getMessage() );
}