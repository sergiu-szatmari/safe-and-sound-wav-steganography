<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

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
        'UploadManager',
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

    public static function navbar( $page = 'Home' )
    {
        ?>
            <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
                <a class="navbar-brand mb-0 h1" style="position: fixed; left: 10px;">
                    Safe & Sound
                </a>

                <ul class="navbar-nav" style="align-items: ">
                <?php
                    foreach ( self::$actionClassMapping as $action => $className )
                    {
                        if ( $page == $className ) {
                            ?> 
                            <li class="nav-item active"> 
                            <?php
                        } else {
                            ?> 
                            <li class="nav-item"> 
                            <?php
                        }
                        ?> 
                        <a class="nav-link" href="index.php?action=<?php echo $action; ?>">
                            <?php 
                                echo $className; 
                                if ( $page == $className ) {
                                    echo "<span class='sr-only'>(current)</span>"; 
                                }
                            ?>
                        </a>
                        </li>
                        <?php                
                    }
                ?>
                </ul>
            </nav>
        <?php
    }
}