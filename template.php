<?php
// $Id$

/**
 * @file
 * Contains theme override functions and preprocess functions for the zentropy theme.
 */

/**
 * Changes the default meta content-type tag to the shorter HTML5 version
 */
function zentropy_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Changes the search form to use the HTML5 "search" input attribute
 */
function zentropy_preprocess_search_block_form(&$vars) {
  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
}

/**
 * Uses RDFa attributes if the RDF module is enabled
 * Lifted from Adaptivetheme for D7, full credit to Jeff Burnz
 * ref: http://drupal.org/node/887600
 */
function zentropy_preprocess_html(&$vars) {
  if (module_exists('rdf')) {
    $vars['doctype'] = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML+RDFa 1.1//EN">' . "\n";
    $vars['rdf']->version = 'version="HTML+RDFa 1.1"';
    $vars['rdf']->namespaces = $vars['rdf_namespaces'];
    $vars['rdf']->profile = ' profile="' . $vars['grddl_profile'] . '"';
  } else {
    $vars['doctype'] = '<!DOCTYPE html>' . "\n";
    $vars['rdf']->version = '';
    $vars['rdf']->namespaces = '';
    $vars['rdf']->profile = '';
  }
  
  /* Since menu is rendered in preprocess_page we need to detect it here to add body classes */
  $has_main_menu = theme_get_setting('toggle_main_menu');
  $has_secondary_menu = theme_get_setting('toggle_secondary_menu');
  
  // Adding classes whether #navigation is here or not
  if ($has_main_menu or $has_secondary_menu) {
    $vars['classes_array'][] = 'with-navigation';
  }
  
  if ($has_secondary_menu) {
    $vars['classes_array'][] = 'with-subnav';
  }
  
  /* Add extra classes to body for advanced theming */
  
  if ($vars['is_admin']) {
    $vars['classes_array'][] = 'admin';
  }
  
	if (!$vars['is_front']) {
		// Add unique classes for each page and website section
		$path = drupal_get_path_alias($_GET['q']);
		list($section, ) = explode('/', $path, 2);
		$vars['classes_array'][] = zentropy_id_safe('page-'. $path);
		$vars['classes_array'][] = zentropy_id_safe('section-'. $section);
		//$vars['template_files'][] = "page-section-" . $section;
		
		if (arg(0) == 'node') {
			if (arg(1) == 'add') {
				if ($section == 'node') {
					array_pop($body_classes); // Remove 'section-node'
				}
				$body_classes[] = 'section-node-add'; // Add 'section-node-add'
			}
			elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
				if ($section == 'node') {
					array_pop($body_classes); // Remove 'section-node'
				}
				$body_classes[] = 'section-node-'. arg(2); // Add 'section-node-edit' or 'section-node-delete'
			}
		}
	}
  
#  krumo($vars);
}

function zentropy_preprocess_page(&$vars) {
  if (isset($vars['node_title'])) {
    $vars['title'] = $vars['node_title'];
  }
}

/** 
 * Implementation of phptemplate_preprocess_node().
 *
 * Adds extra classes to node container for advanced theming
 */
function zentropy_preprocess_node(&$vars) {
  // Striping class
  $vars['classes_array'][] = 'node-' . $vars['zebra'];
  
  // Node is published
  $vars['classes_array'][] = ($vars['status']) ? 'published' : 'unpublished';
  
  // Node has comments?
  $vars['classes_array'][] = ($vars['comment']) ? 'with-comments' : 'no-comments';
  
  if ($vars['sticky']) {
    $vars['classes_array'][] = 'sticky'; // Node is sticky
  }
  
  if ($vars['promote']) {
    $vars['classes_array'][] = 'promote'; // Node is promoted to front page
  }
  
  if ($vars['teaser']) {
    $vars['classes_array'][] = 'node-teaser'; // Node is displayed as teaser.
  }
  
  if ($vars['uid'] && $vars['uid'] === $GLOBALS['user']->uid) {
    $classes[] = 'node-mine'; // Node is authored by current user.
  }
}

function zentropy_preprocess_block(&$vars, $hook) {
  // Add a striping class.
  $vars['classes_array'][] = 'block-' . $vars['zebra'];
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function zentropy_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];
  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('breadcrumb_display');
  if ($show_breadcrumb == 'yes') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $separator = filter_xss(theme_get_setting('breadcrumb_separator'));
      $trailing_separator = $title = '';
      
      // Add the title and trailing separator
      if (theme_get_setting('breadcrumb_title')) {
        if ($title = drupal_get_title()) {
          $trailing_separator = $separator;
        }
      }
      // Just add the trailing separator
      elseif (theme_get_setting('breadcrumb_trailing')) {
        $trailing_separator = $separator;
      }

      // Assemble the breadcrumb
      return implode($separator, $breadcrumb) . $trailing_separator . $title;
    }
  }
  // Otherwise, return an empty string.
  return '';
}

/* 	
 * 	Converts a string to a suitable html ID attribute.
 *  Copied from "zentropy"
 * 	
 * 	 http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 * 	 valid ID attribute in HTML. This function:
 * 	
 * 	- Ensure an ID starts with an alpha character by optionally adding an 'n'.
 * 	- Replaces any character except A-Z, numbers, and underscores with dashes.
 * 	- Converts entire string to lowercase.
 * 	
 * 	@param $string
 * 	  The string
 * 	@return
 * 	  The converted string
 */	
function zentropy_id_safe($string) {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  // If the first character is not a-z, add 'n' in front.
  if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
    $string = 'id'. $string;
  }
  return $string;
}
