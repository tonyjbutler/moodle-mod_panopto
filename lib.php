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
 * Panopto course module library.
 *
 * @package    mod_panopto
 * @copyright  2017 Lancaster University (http://www.lancaster.ac.uk/)
 * @author     Ruslan Kabalin (https://github.com/kabalin)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * List of features supported in Panopto module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function panopto_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:                  return false;
        case FEATURE_GROUPINGS:               return false;
        case FEATURE_MOD_INTRO:               return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS: return true;
        case FEATURE_GRADE_HAS_GRADE:         return false;
        case FEATURE_GRADE_OUTCOMES:          return false;
        case FEATURE_BACKUP_MOODLE2:          return false;
        case FEATURE_SHOW_DESCRIPTION:        return true;

        default: return null;
    }
}

/**
 * Returns all other caps used in module
 * @return array
 */
function panopto_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function panopto_reset_userdata($data) {
    return array();
}

/**
 * List of view style log actions
 * @return array
 */
function panopto_get_view_actions() {
    return array('view', 'view all');
}

/**
 * List of update style log actions
 * @return array
 */
function panopto_get_post_actions() {
    return array('update', 'add');
}

/**
 * Add Panopto instance.
 *
 * @param object $data
 * @param object $mform
 * @return int new panopto instance id
 */
function panopto_add_instance($data, $mform) {
    global $DB;

    $data->timemodified = time();
    $data->id = $DB->insert_record('panopto', $data);

    return $data->id;
}

/**
 * Update Panopto instance.
 *
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function panopto_update_instance($data, $mform) {
    global $CFG, $DB;

    $data->timemodified = time();
    $data->id           = $data->instance;

    $DB->update_record('panopto', $data);

    return true;
}

/**
 * Delete Panopto instance.
 *
 * @param int $id
 * @return bool true
 */
function panopto_delete_instance($id) {
    global $DB;

    if (!$panopto = $DB->get_record('panopto', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('panopto', array('id' => $panopto->id));

    return true;
}