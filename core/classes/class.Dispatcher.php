<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Dispatcher 
{
    private static $requiredClassesDir = __DIR__ . '/../utils/';
    private static $requiredClasses = [
        'Constants',
        'Components',
        'Utils'
    ];

    // TODO: Security
    private $allowedActions = [
        'home',
        'about',
        'download',
    ];

    private function checkRequirements()
    {
        foreach ( self::$requiredClasses as $className ) {
            if ( !file_exists( self::$requiredClassesDir . 'class.' . $className . '.php') ) {
                throw new Exception("$className not found.");
            }
        }
    }

    private function loadComponents()
    {
        foreach ( self::$requiredClasses as $className ) {
            require_once( self::$requiredClassesDir . 'class.' . $className . '.php' );
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

    public function __construct()
    {
        $this->checkRequirements();

        $this->loadComponents();
    }

    public function listen()
    {
        // TODO: Security
        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->get();
                break;

            case 'POST':
                $this->post();
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

        if ( in_array($action, $this->allowedActions) )
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