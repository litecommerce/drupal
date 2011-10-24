<?php
// vim: set ts=4 sw=4 sts=4 et:

// $Id: dev_install.php 4783 2010-12-24 09:32:25Z svowl $

/**
 * @file
 * Initiates a browser-based installation of Drupal (for development only).
 * Condition of successfull installation:
 * - xlite is need to be deployed and installed (and cache is built)
 * - path to xlite directory must be '~user/public_html/xlite/src'
 * - file sites/default/settings.php must be presented and configured
 */


error_reporting(E_ALL ^ E_DEPRECATED);
ini_set('display_errors', true);

// Exit early if running an incompatible PHP version to avoid fatal errors.
if (version_compare(PHP_VERSION, '5.3.0') < 0) {
  print 'Your PHP installation is too old. LC CMS requires at least PHP 5.3.0';
  exit;
}

define('DEV_MODE', 1);

$d = dirname(__FILE__);
$drupal_root_dir = null;
if (preg_match('/.\.dev$/Ss', $d)) {
    $drupal_root_dir = $d . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

} else {
    while ($d != dirname($d) && !file_exists($d . DIRECTORY_SEPARATOR . 'index.php')) {
        $d = dirname($d);
    }
    if ($d && $d != dirname($d)) {
        $drupal_root_dir = $d;
    }
}

if (isset($drupal_root_dir))  {
    $drupal_root_dir = realpath($drupal_root_dir);

} else {
    echo ('Drupal root not found!' . PHP_EOL);
    die(1);
}

chdir($drupal_root_dir);

/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());


// Drop drupal tables
if (!isset($_GET['profile']) && !isset($_POST['profile'])) {
	require_once '.dev/db_clean.php';
}

if (isset($_GET['test']) || isset($_POST['test'])) {
	//define('LCWEB', 1);
	$devProfile = 'litecommerce_test';

} else {
	$devProfile = 'litecommerce';
}

/**
 * Global flag to indicate that site is in installation mode.
 */
define('MAINTENANCE_MODE', 'install');


$_COOKIE['lc'] = 1;


function dev_install_configure_form($form)
{
//	$form['site_information']['site_name']['#default_value'] = 'Ecommerce CMS';
	$form['site_information']['site_mail']['#default_value'] = 'rnd_tester@cdev.ru';
	$form['admin_account']['account']['name']['#default_value'] = 'master';
    $form['admin_account']['account']['mail']['#default_value'] = 'rnd_tester@cdev.ru';

    $form['server_settings']['site_default_country']['#default_value'] = 'US';

	$form['update_notifications']['update_status_module']['#default_value'] = array();

	$form['admin_account']['account']['pass'] = array(
		'#type' => 'textfield',
	    '#title' => st('Password'),
		'#required' => TRUE,
		'#default_value' => 'master',
		'#weight' => 0,
		'#size' => 25
	);

    drupal_add_js('setTimeout(function() { jQuery(\'#install-configure-form\').submit(); }, 3000);', 'inline');

	return $form;
}


// Start the installer.
require_once DRUPAL_ROOT . '/.dev/dev_install.inc.php';

install_drupal();
