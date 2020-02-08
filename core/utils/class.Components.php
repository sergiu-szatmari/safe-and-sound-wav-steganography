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

    private static $aboutPageTextContent = [
        'safe-and-sound-about'  => [
            'title' =>
                '
                "Safe & Sound" WAV Steganography Webapp
                ',
            'content' =>
                '
                The app uses the "Least Significant Bit" steganography method to embed a secret message in a .wav audio file. The webapp uses a Python script to do the proper embedding of the message, and PHP language for preprocessing the data and web UI rendering.
                ',
        ],
        'steganography-about'   => [
            'title' =>
                '
                Steganography
                ',
            'content' =>
                '
                "Steganography" represents the practice of concealing a file, message, image or video within another file, message or other type of media. The advantage of steganography over cryptography alone is that the intended secret message does not attract attention to itself as an object of scrutiny. Plainly visible encrpyted messages, no matter how unbreakable they are, arouse interest and may in themselves be incrimitating in countries in which encryption is illegal.
                ',
        ],
        'lsb-about'             => [
            'title' =>
                '
                Audio steganography method: "Least Significant Bit"
                ',
            'content' =>
                '
                The "LSB" method is one of the earliest that was used in steganography. It consists of embedding each bit from the message in the least significant bit of the cover audio in a deterministic way.
                
                <img alt="lsb" src="' . Constants::_LSB_SRC . '" />
                '
        ]
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
            <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
                <div>
                    <a class="safe-and-sound-brand-logo">
                        <img alt="logo" src="<?= Constants::_LOGO_SRC ?>" />
                    </a>
                    <a class="safe-and-sound-brand navbar-brand navbar-left mb-0 h1" style="color: white; margin-left: 15px;    " href="index.php">
                        Safe & Sound
                    </a>
                </div>

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

    public static function textBlock( $title, $text )
    {
        ?>
        <div class="about-block-content-container">
            <div class="about-block-title">
                <h3 class="bold-text">
                    <?= $title ?>
                </h3>
            </div>
            <div class="about-block-content">
                <h3>
                    <?= str_replace("\n", "<br/>", $text); ?>
                </h3>
            </div>
        </div>
        <?php
    }

    public static function pageContent( $page, $section, $subsection )
    {
        switch ( $page )
        {
            case 'About':
                return self::$aboutPageTextContent[$section][$subsection];
                break;

            default:
                return '';
        }
    }
}