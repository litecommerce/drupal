<?php
// vim: set ts=4 sw=4 sts=4 et ft=php:

/**
 * @file
 * Ecommerce CMS profile
 *
 * @category  Litecommerce connector
 * @package   Litecommerce connector
 * @author    Creative Development LLC <info@cdev.ru>
 * @copyright Copyright (c) 2010 Creative Development LLC <info@cdev.ru>. All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2
 * @link      http://www.litecommerce.com/
 * @since     1.0.0
 */

if (file_exists(__DIR__ . '/litecommerce/litecommerce.profile.php')) {
    include_once __DIR__ . '/litecommerce/litecommerce.profile.php';

} else {
    include_once __DIR__ . '/../litecommerce/litecommerce.profile';
}


/**
 * Alter the default installation tasks list.
 * Extends the tasks list with the profile specific tasks
 *
 * @param array $tasks         An array of all available installation tasks
 * @param array $install_state An array of information about the current installation state
 *
 * @hook   install_tasks_alter
 * @return void
 * @since  1.0.0
 */
function litecommerce_test_install_tasks_alter(array &$tasks, array $install_state) {
    litecommerce_install_tasks_alter($tasks, $install_state);
}

/**
 * Allows the profile to alter the site configuration form
 *
 * @param array $form       Form description
 * @param array $form_state Form state
 *
 * @hook   form_FORM_ID_alter
 * @return void
 * @since  1.0.0
 */
function litecommerce_test_form_install_configure_form_alter(array &$form, array &$form_state) {
    litecommerce_form_install_configure_form_alter($form, $form_state);
}

