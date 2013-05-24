<?php

/**
 * Environment Switching class for CakePHP
 *
 * The class should be included in your webroot/index file right after the APP_DIR
 * is defined, since this class uses the ROOT and APP_DIR constants.
 *
 * PHP 5
 *
 * Angel S. Moreno : Environment Switching class for CakePHP
 * Copyright 2013, Angel S. Moreno (http://github.com/angelxmoreno)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	Copyright 2013, Angel S. Moreno (http://github.com/angelxmoreno)
 * @license	MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link	https://github.com/angelxmoreno/CakePHP-Environment-Switcher
 * @file	EnvSwitcher.php
 */
class EnvSwitcher {

	/**
	 * the current APP_ENV valur
	 * @var String
	 */
	protected static $_app_env;

	/**
	 * Gets the APP_ENV or triggers an error if known is defined
	 */
	protected static function _init() {
		if (is_null(self::$_app_env)) {
			self::$_app_env = getenv('APP_ENV');
			if (!self::$_app_env) {
				trigger_error('The current Application Environment variable is not set', E_USER_ERROR);
			}
		}
	}

	/**
	 * returns the current APP_ENV
	 *
	 * @return string The value of $_app_env
	 */
	public function getEnv() {
		self::_init();
		return self::$_app_env;
	}

	/**
	 * Includes the base file of a given path using the current APP_ENV value
	 * see includeFile()
	 *
	 * @param String $path The normal path of a file
	 * @return void
	 */
	public function includeBaseFile($path) {
		$file = basename($path);
		self::includeFile($file);
	}

	/**
	 * Includes a file using the current APP_ENV value or includes the file from the
	 * _default directory
	 *
	 * @param String $file The file you want to include
	 * @return void
	 */
	public function includeFile($file) {
		self::_init();
		$location = self::getFilePath($file);
		$default = self::getFilePath($file, '_default');
		if (is_file($location)) {
			include $location;
		} elseif (!is_file($default)) {
			trigger_error('Trying to include the file "' . $file . '" but it is not found in "' . $location . '" or "' . $default . '".', E_USER_ERROR);
		} else {
			include $default;
		}
	}

	/**
	 * build the path of a file using a given APP_ENV or a give APP_ENV
	 *
	 * @param String A file
	 * @param String $env The environment used to generate the path, defaults to current value of APP_ENV
	 * @return String $path The path of the file using the $env value
	 */
	public function getFilePath($file, $env = null) {
		self::_init();
		if (!$env) {
			$env = self::$_app_env;
		}
		return ROOT . DS . APP_DIR . DS . 'Config' . DS . 'envs' . DS . $env . DS . $file;
	}

}
