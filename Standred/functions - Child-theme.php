<?php
/**
 * 8poinlaw functions and definitions
 * @package eightpointlaw
 * @copyright Copyright (C) 2019
 * @author
 * @since 1.0.0
 */

define('EPL_THEME_DIR', get_template_directory());
define('EPL_THEME_URI', get_template_directory_uri());
define('EPL_THEME_NAME', 'eightpointlaw');
define('EPL_THEME_VERSION', '1.0');
define('EPL_SITE_URL', SITE_URL());
define('EPL_LIBS_DIR', EPL_THEME_DIR. '/functions');
define('EPL_INC_DIR', EPL_THEME_DIR. '/inc');

/* --------------------------------------------------------------------------------------------------
 * Loads Theme Files
* ----------------------------------------------------------------------------------------------- */
 
// Loads Theme Functions -----------------------------------------------------------------------------
require_once(EPL_LIBS_DIR. '/theme-functions.php');

// Load Header Theme Fucntion ------------------------------------------------------------------------
require_once(EPL_LIBS_DIR. '/theme-head.php');

// Take Actions On Some Event Occur Using Filter/Hook ------------------------------------------------
require_once(EPL_LIBS_DIR. '/theme-actions.php');

// Load Theme Menu ------------------------------------------------------------------------------------
require_once(EPL_LIBS_DIR. '/theme-menu.php');

// Load ajax ------------------------------------------------------------------------------------
require_once(EPL_LIBS_DIR. '/_ajax.php');

// Load Some Admin Related Customised File  -----------------------------------------------------------
//require_once(EPL_THEME_DIR. '/inc/admin/admin-function.php');

// Load Meta Fields ---------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/epl_meta_fields.php');

// Load Testimonial Post Type -------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/custom-post/epl_testimonial.php');

// Load Testimonial Post Type -------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/custom-post/epl_partners.php');

// Load Expertise Post Type ---------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/custom-post/epl_practices.php');

// Load Team Post Type --------------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/custom-post/epl_team.php');

// Load Team Post Type --------------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/custom-post/epl_jobs.php');

// Load Service Post Type -----------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/custom-post/epl_service.php');

// Load Page Meta  ------------------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/epl_page_meta.php');

// Load Page Meta  ------------------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/epl_post_meta.php');

// Load editor Stayle  ------------------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/epl-editor-format.php');

// Load Shortcode  ------------------------------------------------------------------------------------
require_once(EPL_INC_DIR. '/shortcode/epl-shortcode.php');