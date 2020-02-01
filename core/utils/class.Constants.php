<?php

defined('_SAFE_AND_SOUND_VALID_ACCESS') or die('Invalid access');

class Constants
{
    private const _DIR_CONSTANTS                    = __DIR__;
    private const _DIR_PROJECT                      = self::_DIR_CONSTANTS . '/../../';
    public const _DIR_CORE                          = self::_DIR_CONSTANTS . '/../';
    public const _DIR_CLASS                         = self::_DIR_CORE . 'classes/';
    public const _DIR_PAGE                          = self::_DIR_CORE . 'pages/';
    public const _DIR_INTERFACE                     = self::_DIR_CORE . 'interfaces/';
    public const _DIR_UTILS                         = self::_DIR_CORE . 'utils/';

    public const _DIR_UPLOADS                       = self::_DIR_PROJECT . 'uploads/';
    public const _DIR_EXTERNAL                      = self::_DIR_PROJECT . 'external/';
    public const _DIR_WEBFILES                      = self::_DIR_PROJECT . 'webfiles/';
    public const _DIR_WEBFILES_RELATIVE             = 'webfiles/';
    public const _DIR_JS                            = self::_DIR_WEBFILES_RELATIVE . 'js/';
    public const _DIR_CSS                           = self::_DIR_WEBFILES_RELATIVE . 'css/';
    public const _DIR_IMG                           = self::_DIR_WEBFILES_RELATIVE . 'img/';

    public const _PAGE_PREFIX                       = self::_DIR_PAGE       . 'page.';
    public const _CLASS_PREFIX                      = self::_DIR_CLASS      . 'class.';
    public const _INTERFACE_PREFIX                  = self::_DIR_INTERFACE  . 'interface.';
    public const _STEG_FILE_PREFIX                  = 'steg_';

    public const _PHP_EXTENSION                     = '.php';
    public const _WAV_EXTENSION                     = '.wav';
    public const _CSS_EXTENSION                     = '.css';
    public const _JS_EXTENSION                      = '.js';
    public const _PNG_EXTENSION                     = '.png';

    public const _WAV_FILE_TYPE                     = 'audio/wav';
    public const _WAV_FILE_INT_MAX_SIZE_ALLOWED     = 25000000;

    public const _LOGO_IMG_NAME                      = 'safe-and-sound-logo';
}