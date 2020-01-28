<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Dispatcher 
{
    private static $requiredClassesDir = __DIR__ . '/../utils/';
    private static $requiredClasses = [
        'class.Constants.php',
        'class.Components.php',
        'class.Utils.php'
    ];

    // TODO: Security
    private static $allowedActions = [
        'home',
        'about',
        'download',
    ];

    private static function checkRequirements()
    {
        foreach ( self::$requiredClasses as $className ) {
            if ( !file_exists( self::$requiredClassesDir . $className) ) {
                throw new Exception("$className not found.");
            }
        }
    }

    private static function loadComponents()
    {
        foreach ( self::$requiredClasses as $className ) {
            require_once( self::$requiredClassesDir . $className );
        }

        // Loading interfaces
        foreach ( Components::getInterfaces() as $interface ) {
            require_once( Constants::_INTERFACE_PREFIX . $interface . Constants::_PHP_EXTENSION );
        }
        
        // Loading pages
        foreach ( Components::getPages() as $page ) {
            require_once( Constants::_PAGE_PREFIX . $page . Constants::_PHP_EXTENSION );
        }

        // Loading classes
        foreach ( Components::getClasses() as $class ) {
            require_once( Constants::_CLASS_PREFIX . $class . Constants::_PHP_EXTENSION );
        }
    }

    private static function initialize()
    {
        self::checkRequirements();

        self::loadComponents();
    }

    public static function listen()
    {
        self::initialize();

        // TODO: Security
        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'GET':
                self::get();
                break;

            case 'POST':
                self::post();
                break;

            default:
                NotFound404::setUnknownAction( $_SERVER['REQUEST_METHOD'] );
                NotFound404::display();
        }
    }

    private function get()
    {
        $action = $_GET['action'] ?? null;
        if ( !$action ) {
            Home::display();
        }

        if ( in_array($action, self::$allowedActions) )
        {
            $actionClassMapping = Components::getActionClassMapping();
            $pageClass = $actionClassMapping[$action];
            $pageClass::display();
        }
        else {
            NotFound404::setUnknownAction( $action );
            NotFound404::display();
        }
    }

    private function post()
    {
        $action = $_POST['action'] ?? null;
        if ( !$action ) {
            NotFound404::setUnknownAction('Empty action');
            NotFound404::display();
        }

        switch ($action)
        {
            case 'upload':

                $filename = FileManager::onUpload();
                if ( !$filename ) {
                    InternalServerError500::display('Upload failed');
                }

                $message        = $_POST['message'];
                $stegFilename   = SteganographyManager::hide( $filename, $message );

                Upload::display( $stegFilename );
                
                break;

            case 'download':

                if ( !$_POST['stegFilename'] ) {
                    InternalServerError500::display('Invalid request body.');
                }

                $stegFilename = $_POST['stegFilename'];
                FileManager::onDownload( $stegFilename );
                
                break;

            default:
                NotFound404::setUnknownAction( $action );
                NotFound404::display();
        }
    }

};