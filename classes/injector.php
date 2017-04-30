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

namespace local_inlinemanual;

defined('MOODLE_INTERNAL') || die();

/**
 * Class injector
 *
 * @package    inlinemanual
 * @copyright  Marek Sotak, Inline Manual 2017
 * @author     Marek Sotak <marek@inlinemanual.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class injector {
    /** @var bool */
    private static $injected = false;

    public static function inject() {
        if (self::$injected) {
            return;
        }
        self::$injected = true;

        $engine = null;

        $enabled = get_config('local_inlinemanual', 'enabled');

        if ($enabled) {
            $classname = "\\local_inlinemanual\\api\\inlinemanual";
            $engine = new $classname;
            $engine::insert_tracking();
        }
    }

    public static function reset() {
        self::$injected = false;
    }
}