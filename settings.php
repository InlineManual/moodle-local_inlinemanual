<?php
// This file is part of the Inline Manual plugin for Moodle
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Inline Manual
 *
 * This module provides integration with Inline Manual service
 * https://inlinemanual.com
 *
 * @package    inlinemanual
 * @copyright  Marek Sotak, Inline Manual 2017
 * @author     Marek Sotak <marek@inlinemanual.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if (is_siteadmin()) {
    $settings = new admin_settingpage('local_inlinemanual', get_string('pluginname', 'local_inlinemanual'));
    $ADMIN->add('localplugins', $settings);

    $name = 'local_inlinemanual/enabled';
    $title = get_string('enabled', 'local_inlinemanual');
    $description = get_string('enabled_desc', 'local_inlinemanual');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $settings->add($setting);

    $name = 'local_inlinemanual/siteapikey';
    $title = get_string('siteapikey', 'local_inlinemanual');
    $description = get_string('siteapikey_desc', 'local_inlinemanual');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'local_inlinemanual/trackadmin';
    $title = get_string('trackadmin', 'local_inlinemanual');
    $description = get_string('trackadmin_desc', 'local_inlinemanual');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $settings->add($setting);

    $name = 'local_inlinemanual/roletracking';
    $title = get_string('roletracking', 'local_inlinemanual');
    $description = get_string('roletracking', 'local_inlinemanual');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $settings->add($setting);
}