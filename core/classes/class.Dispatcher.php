<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Dispatcher 
{
    private $pagesToBeLoaded = [
        'Home',
        'About',
        'NotFound404',
        'InternalServerError500',
        'Upload',
        'Download',
    ];

    private $classesToBeLoaded = [
        'UploadManager',
    ];

    private $interfacesToBeLoaded = [
        'iPage',
    ];

    private $pagesPrefix = './pages/page.';
    private $classPrefix = './core/classes/class.';
    private $interfacePrefix = './core/interfaces/interface.';
    private const EXTENSION = '.php';

    private $actionClassMapping = [
        'home' => 'Home',
        'about' => 'About',
        'download' => 'Download'
    ];

    private $allowedActions = [
        'home',
        'about',
        'download',
    ];

    public function __construct()
    {
        // Load interfaces
        foreach ( $this->interfacesToBeLoaded as $interface ) {
            require_once($this->interfacePrefix . $interface . self::EXTENSION);
        }
        
        // Load pages
        foreach ( $this->pagesToBeLoaded as $page ) {
            require_once($this->pagesPrefix . $page . self::EXTENSION);
        }

        // Load classes
        foreach ( $this->classesToBeLoaded as $class ) {
            require_once($this->classPrefix . $class . self::EXTENSION);
        }
    }

    public function listen()
    {
        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'GET':
                $this->get();
                break;

            case 'POST':
                $this->post();
                break;

            default:
                echo 'Default branch: ' . $_SERVER['REQUEST_METHOD'];
        }
    }

    public function get()
    {
        if ( !isset($_GET['action']) || !($_GET['action']) ) {
            Home::display();
        } else {
            $action = $_GET['action'];
            if ( in_array($action, $this->allowedActions) )
            {
                $pageClass = $this->actionClassMapping[$action];
                $pageClass::display();
            }
            else {
                NotFound404::setUnknownAction( $action );
                NotFound404::display();
            }
        }
    }

    public function post()
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
                    InternalServerError500::display();
                }
                Upload::display();
        }
    }

};