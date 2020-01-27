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

    public const _PAGE_PREFIX                       = self::_DIR_PAGE . 'page.';
    public const _CLASS_PREFIX                      = self::_DIR_CLASS . 'class.';
    public const _INTERFACE_PREFIX                  = self::_DIR_INTERFACE . 'interface.';
    public const _STEG_FILE_PREFIX                  = 'steg_';

    public const _PHP_EXTENSION                     = '.php';
    public const _WAV_EXTENSION                     = '.wav';

    public const _WAV_FILE_TYPE                     = 'audio/wav';
    public const _WAV_FILE_INT_MAX_SIZE_ALLOWED     = 25000000;
}