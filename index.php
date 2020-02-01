<?php

define('_SAFE_AND_SOUND_VALID_ACCESS', 1);

try {

    require_once( __DIR__ . '/core/classes/class.Dispatcher.php' );
    require_once( __DIR__ . '/core/interfaces/interface.iPage.php' );
    require_once( __DIR__ . '/core/utils/class.Components.php' );
    require_once( __DIR__ . '/core/pages/page.InternalServerError500.php' );

    Dispatcher::listen();

} catch (Exception $ex) {

    InternalServerError500::display( $action = null, $errorMessage = $ex->getMessage() );
}