#!/usr/bin/php -q
<?php
/**
 * Command-line code generation utility to automate programmer chores.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Console
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/** CLI fix for EnvSwitcher * */
$root = dirname(dirname(dirname(__FILE__)));
$app_dir = basename(dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
include($root . DS . $app_dir . DS . 'Lib' . DS . 'EnvSwitcher' . DS . 'EnvSwitcher.php');
EnvSwitcher::init($root . DS . $app_dir . DS . 'Config' . DS . 'envs' . DS);
EnvSwitcher::includeFile('cake_include.php');
define('CAKEPHP_SHELL', true);
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);

/** * */
$dispatcher = CORE_PATH . 'Cake' . DS . 'Console' . DS . 'ShellDispatcher.php';

if (function_exists('ini_set')) {
	// the following line differs from its sibling
	// /app/Console/cake.php
	ini_set('include_path', $root . PATH_SEPARATOR . CAKE_CORE_INCLUDE_PATH . PATH_SEPARATOR . ini_get('include_path'));
}

if (!include ($dispatcher)) {
	trigger_error('Could not locate CakePHP core files.', E_USER_ERROR);
}
unset($paths, $path, $dispatcher, $root, $ds, $app_dir);

return ShellDispatcher::run($argv);
