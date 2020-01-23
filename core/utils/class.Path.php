<?php

!defined('_SAFE_AND_SOUND_VALID_ACCESS') && die('Invalid access');

class Path
{
    public const _DIR_CORE          = './core/';
    public const _DIR_CLASS         = self::_DIR_CORE . 'classes/';
    public const _DIR_PAGE          = self::_DIR_CORE . 'pages/';
    public const _DIR_INTERFACE     = self::_DIR_CORE . 'interfaces/';
    public const _DIR_UTILS         = self::_DIR_CORE . 'utils/';
    
    public const _DIR_UPLOADS       = './uploads/';

    public const _PAGE_PREFIX       = self::_DIR_PAGE . 'page.';
    public const _CLASS_PREFIX      = self::_DIR_CLASS . 'class.';
    public const _INTERFACE_PREFIX  = self::_DIR_INTERFACE . 'interface.';

    public const _PHP_EXTENSION     = '.php';
}