<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Components
{
    private static $pagesArray = [
        'Home',
        'About',
        'NotFound404',
        'InternalServerError500',
        'Upload',
        'Download',
    ];
    
    private static $classesArray = [
        'FileManager',
        'SteganographyManager',
    ];

    private static $interfacesArray = [
        'iPage',
    ];

    private static $actionClassMapping = [
        'home'      => 'Home',
        'about'     => 'About',
        'download'  => 'Download'
    ];

    public static function getPages()
    {
        return self::$pagesArray;
    }

    public static function getClasses()
    {
        return self::$classesArray;
    }

    public static function getInterfaces()
    {
        return self::$interfacesArray;
    }

    public static function getActionClassMapping()
    {
        return self::$actionClassMapping;
    }

    public static function bootstrap()
    {
        ?>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <?php
    }

    public static function navbar( $page = '' )
    {
        self::css( 'Body-General' );
        self::css( 'Navbar' );
        ?>
            <nav class="navbar navbar-expand-lg navbar-light justify-content-end">
                <a class="safe-and-sound-brand-logo">
                    <img alt="logo" src="<?= Constants::_DIR_IMG . Constants::_LOGO_IMG_NAME . Constants::_PNG_EXTENSION ?>" />
                </a>
                <a class="safe-and-sound-brand navbar-brand navbar-left mb-0 h1" style="color: white; position: fixed; left: 10px;" href="index.php">
                    Safe & Sound
                </a>

                <ul class="navbar-nav">
                <?php
                    foreach ( self::$actionClassMapping as $action => $className )
                    {
                        if ( $page == $className ) {
                            ?> <li class="nav-item active-page-nav"> <?php
                        } else {
                            ?> <li class="nav-item"> <?php
                        }
                        ?> 
                        <a class="nav-link" href="index.php?action=<?php echo $action; ?>">
                            <span class="page-name">
                                <?= $className; ?>
                            </span>
                        </a>
                        </li>
                        <?php                
                    }
                ?>
                </ul>
            </nav>

        <?php
    }

    public static function javascript( $page )
    {
        ?>
        <script>
            <?php include_once( Constants::_DIR_JS . $page . Constants::_JS_EXTENSION ); ?>
        </script>
        <?php
    }

    public static function css( $page ) 
    {
        ?>
            <style type="text/css">
                <?php include_once( Constants::_DIR_CSS . $page . Constants::_CSS_EXTENSION ); ?>
            </style>
        <?php
    }
}