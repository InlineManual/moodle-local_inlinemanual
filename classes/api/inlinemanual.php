<?php
// This file is part of Moodle - http://moodle.org/
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

namespace local_inlinemanual\api;

use stdClass;

defined('MOODLE_INTERNAL') || die();

use core\session\manager;

/**
 * Local inlinemanual class.
 */
class inlinemanual {
    /**
     * Encode a substring if required.
     *
     * @param string  $input  The string that might be encoded.
     * @param boolean $encode Whether to encode the URL.
     * @return string
     */
    private static function might_encode($input, $encode) {
        if (!$encode) {
            return str_replace("'", "\'", $input);
        }

        return urlencode($input);
    }

    /**
     * Whether to track this request.
     *
     * @return boolean
     *   The outcome of our deliberations.
     */
    public static function should_track() {
        if (!isloggedin()) {
            return false;
        }
        if (!is_siteadmin()) {
            return true;
        }

        $trackadmin = get_config('local_inlinemanual', 'trackadmin');
        return ($trackadmin == 1);
    }

    /**
     * Get the user full name to record in tracking, taking account of masquerading if necessary.
     *
     * @return string
     *   The full name to log for the user.
     */
    public static function user_full_name() {
        global $USER;
        $user = $USER;

        $realname = fullname($user);
        return $realname;
    }
    /**
     * Get the user full name to record in tracking, taking account of masquerading if necessary.
     *
     * @return string
     *   The full name to log for the user.
     */
    public static function user_name() {
        global $USER;
        $user = $USER;

        return $user->username;
    }
    /**
     * Get the user full name to record in tracking, taking account of masquerading if necessary.
     *
     * @return string
     *   The full name to log for the user.
     */
    public static function user_id() {
        global $USER;
        $user = $USER;

        return $user->id;
    }
    /**
     * Get the user full name to record in tracking, taking account of masquerading if necessary.
     *
     * @return string
     *   The full name to log for the user.
     */
    public static function user_created() {
        global $USER;
        $user = $USER;

        return $user->timecreated;
    }
    /**
     * Get the user role to record in tracking, taking account of masquerading if necessary.
     *
     * @return string
     *   The role to log for the user.
     */
    public static function user_role() {
        global $COURSE, $USER;
        $user = $USER;

        // get course context
        $context = \context_course::instance($COURSE->id);
        $uContext = get_user_roles($context, $USER->id);

        $roles = array();

        if (!empty($uContext)) {
            foreach($uContext as $role) {
                $roles[] = $role->shortname;
            }
            return json_encode($roles);
        }
        return false;
    }
    public static function course_id() {
        global $COURSE;
        return $COURSE->id;
    }
    public static function insert_tracking() {
        global $CFG, $PAGE, $OUTPUT;

        if (self::should_track()) {
            $track = array();

            $user_id = self::user_id();
            if ($user_id) {
                $track[] = "'uid' : '".$user_id."'";
            }

            $user_name = self::user_name();
            if ($user_name) {
                $track[] = "'username' : '".$user_name."'";
            }

            $user_created = self::user_created();
            if ($user_created) {
                $track[] = "'created' : ".$user_created;
            }

            $user_full_name = self::user_name();
            if ($user_full_name) {
                $track[] = "'name' : '".$user_full_name."'";
            }

            if (get_config('local_inlinemanual', 'roletracking')) {
                $user_roles = self::user_role();
                if ($user_roles) {
                    $track[] = "'roles' : ".$user_roles;
                }
            }

            $template = new stdClass();

            $template->tracking = "{".implode(",", $track)."}";

            $template->siteapikey = get_config('local_inlinemanual', 'siteapikey');
            $script = $OUTPUT->render_from_template('local_inlinemanual/inlinemanual', $template);
        }
    }
}
