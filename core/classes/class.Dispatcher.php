<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Dispatcher 
{
    private static $pathFile        = __DIR__ . '/../utils/class.Path.php'; 
    private static $componentsFile  = __DIR__ . '/../utils/class.Components.php';

    // TODO: Security
    private $allowedActions = [
        'home',
        'about',
        'download',
    ];

    private function checkRequirements()
    {
        if ( !file_exists(self::$pathFile) )
        {
            throw new Exception('Path file not found');
        }

        if ( !file_exists(self::$componentsFile) )
        {
            throw new Exception('Components file not found');
        }
    }

    private function loadComponents()
    {
        require_once( self::$pathFile );
        require_once( self::$componentsFile );

        // Loading interfaces
        foreach ( Components::getInterfaces() as $interface ) {
            require_once(Path::_INTERFACE_PREFIX . $interface . Path::_PHP_EXTENSION);
        }
        
        // Loading pages
        foreach ( Components::getPages() as $page ) {
            require_once(Path::_PAGE_PREFIX . $page . Path::_PHP_EXTENSION);
        }

        // Loading classes
        foreach ( Components::getClasses() as $class ) {
            require_once(Path::_CLASS_PREFIX . $class . Path::_PHP_EXTENSION);
        }
    }

    public function __construct()
    {
        $this->checkRequirements();

        $this->loadComponents();
    }

    public function listen()
    {
        // Security ?
        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->get();
                break;

            case 'POST':
                $this->post();
                break;

            default:
                // echo 'Default branch: ' . $_SERVER['REQUEST_METHOD'];
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
                $uploadManager = new UploadManager();
                $filename = $uploadManager->manageUpload();
                if ( !$filename ) {
                    InternalServerError500::display('Upload failed');
                }
                Upload::display();
        }
    }

};