<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Dispatcher 
{
    private static $constFile       = __DIR__ . '/../utils/class.Constants.php'; 
    private static $componentsFile  = __DIR__ . '/../utils/class.Components.php';

    // TODO: Security
    private $allowedActions = [
        'home',
        'about',
        'download',
    ];

    private function checkRequirements()
    {
        if ( !file_exists(self::$constFile) )
        {
            throw new Exception('Constants file not found');
        }

        if ( !file_exists(self::$componentsFile) )
        {
            throw new Exception('Components file not found');
        }
    }

    private function loadComponents()
    {
        require_once( self::$constFile );
        require_once( self::$componentsFile );

        // Loading interfaces
        foreach ( Components::getInterfaces() as $interface ) {
            require_once(Constants::_INTERFACE_PREFIX . $interface . Constants::_PHP_EXTENSION);
        }
        
        // Loading pages
        foreach ( Components::getPages() as $page ) {
            require_once(Constants::_PAGE_PREFIX . $page . Constants::_PHP_EXTENSION);
        }

        // Loading classes
        foreach ( Components::getClasses() as $class ) {
            require_once(Constants::_CLASS_PREFIX . $class . Constants::_PHP_EXTENSION);
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
        if ( !isset($_GET['action']) || !($_GET['action']) ) {
            Home::display();
        } else {
            $action = $_GET['action'];
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

                $filename = UploadManager::onUpload();
                if ( !$filename ) {
                    InternalServerError500::display('Upload failed');
                }

                $message = $_POST['message'];

                SteganographyManager::hide( $filename, $message );

                Upload::display();
        }
    }

};