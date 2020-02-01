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
        self::css( 'Body-General' );
        self::css( 'Navbar' );
        ?>
            <nav class="navbar navbar-expand-lg navbar-light justify-content-end">
                <a class="navbar-brand mb-0 h1" style="color: white; position: fixed; left: 10px;" href="index.php">
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
                            <span class="page-name"><?php
                                echo $className;
                            ?></span>
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

            case 'Upload':
                ?>
                <script>
                    setTimeout(() => {
                        document.querySelectorAll('.btn').forEach(button => {
                            button.classList.remove('hidden');
                            button.classList.add('visible');
                            button.style.animation = '2s show ease-in-out';
                            button.addEventListener('animationend', () => {
                                button.style.animation = '';
                            });
                        });
                    }, 2000);
                </script>
                <?php
                break;

            case 'Home':
                ?>
                <script>
                    const hideIdx           = 1;
                    const extractIdx        = 2;
                    const selectElement     = document.querySelector('select');
                    const messageInput      = document.querySelector('#upload-form-message');
                    selectElement.addEventListener('change', () => {

                        switch (selectElement.selectedIndex) {
                            case hideIdx:
                                messageInput.required = true;
                                break;

                            case extractIdx:
                                messageInput.required = false;
                                break;
                        }
                    });
                </script>
                <?php
        }
    }

    public static function css( $page ) 
    {
        switch ( $page ) 
        {
            case 'Body-General':
                ?>
                <style>
                    body {
                        background: linear-gradient(#87B784, #9DC497, #B6D6AD, #B9D8B0, #C1DEB3);
                    }
                </style>
                <?php
                break;

            case 'Navbar':
                ?>
                <style>
                    .navbar-brand {
                        user-select: none;
                        cursor: pointer;
                    }

                    nav {
                        background: #72966f;
                        color: white;
                    }

                    li {
                        color: white;
                    }

                    .active-page-nav a span {
                        color: #bababa;
                    }

                    .page-name {
                        color: white;
                    }
                </style>
                <?php
                break;

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

            case 'Home':
                ?>
                <style>
                    .container {
                        text-align: center;
                        top: 10vh;
                        background-color: #f2f2f2;
                        border-radius: 30px;
                        font-family: 'Arial';
                    }

                    form {
                        display: inline-block;
                    }

                    form.upload-form-field {
                        margin-top: 5vh;
                        
                    }

                    input {
                        display: block;
                        margin: auto;
                    }

                </style>
                <?php
                break;

            case 'Upload':
                ?>
                <style>
                    h3 i {
                        font-weight: bold;
                    }

                    .hidden {
                        opacity: 0;
                    }

                    .visible {
                        opacity: 1;
                    }

                    .upload-page-hash {
                        background-color: #f2f2f2;
                        width: auto;
                        margin-top: 30px;
                        text-align: center;
                        overflow: auto;
                        border-radius: 20px;
                        margin-left: 25vw;
                        margin-right: 25vw;
                    }

                    .upload-page-buttons {
                        margin-top: 30px;
                        text-align: center;
                    }

                    @keyframes show {
                        0% {
                            opacity: 0;
                        }
                        50% {
                            opacity: 0.5;
                        }
                        100% {
                            opacity: 1;
                        }
                    }
                </style>
                <?php
        }
    }
}