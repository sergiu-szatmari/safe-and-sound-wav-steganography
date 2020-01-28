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
                            ?> <li class="nav-item active"> <?php
                        } else {
                            ?> <li class="nav-item"> <?php
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

    public static function javascript( $page )
    {
        switch ( $page )
        {
            case 'Download':
                ?>
                <script>
            
                document.querySelectorAll('.btn').forEach(button => {
                
                    const filename = button.value;

                    button.addEventListener('mouseover', () => {
                        button.value = '';
                        button.value = 'Download';
                        button.classList.add('btn-success');
                        button.classList.remove('btn-default');
                    });

                    button.addEventListener('mouseout', () => {
                        button.value = '';
                        button.value = filename;
                        button.classList.add('btn-default');
                        button.classList.remove('btn-success');
                    });

                    button.addEventListener('click', () => {
                        button.value = 'Please wait . . .';
                        setTimeout(() => {
                            button.value = '';
                            button.value = filename;
                            button.classList.add('btn-default');
                            button.classList.remove('btn-success');
                        }, 3000);
                    });
                });
                </script>
                <?php
                break;
        }
    }

    public static function css( $page ) 
    {
        switch ( $page ) 
        {
            case 'Download':
                ?>
                <style>
                    .downloads-container {
                        margin: auto;
                        width: auto;
                        padding-top: 15vh;
                        padding-bottom: 15vh;
                        overflow: auto;
                    }
                </style>
                <?php
                break;
        }
    }
}