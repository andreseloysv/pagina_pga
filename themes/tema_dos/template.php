<?php

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($left, $right) {
    if ($left != '' && $right != '') {
	$class = 'sidebars';
    } else {
	if ($left != '') {
	    $class = 'sidebar-left';
	}
	if ($right != '') {
	    $class = 'sidebar-right';
	}
    }

    if (isset($class)) {
	print ' class="' . $class . '"';
    }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
    if (!empty($breadcrumb)) {
	return '<div class="breadcrumb">' . implode(' › ', $breadcrumb) . '</div>';
    }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
    $vars['tabs2'] = menu_secondary_local_tasks();

    // Hook into color.module
    if (module_exists('color')) {
	_color_page_alter($vars);
    }
}

/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function garland_preprocess_comment_wrapper(&$vars) {
    if ($vars['content'] && $vars['node']->type != 'forum') {
	$vars['content'] = '<h2 class="comments">' . t('Comments') . '</h2>' . $vars['content'];
    }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
    return menu_primary_local_tasks();
}

/**
 * Returns the themed submitted-by string for the comment.
 */
function phptemplate_comment_submitted($comment) {
    return t('!datetime — !username', array(
		'!username' => theme('username', $comment),
		'!datetime' => format_date($comment->timestamp)
	    ));
}

/**
 * Returns the themed submitted-by string for the node.
 */
function phptemplate_node_submitted($node) {
    return t('!datetime — !username', array(
		'!username' => theme('username', $node),
		'!datetime' => format_date($node->created),
	    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
    global $language;

    $iecss = '<link type="text/css" rel="stylesheet" media="all" href="' . base_path() . path_to_theme() . '/fix-ie.css" />';
    if ($language->direction == LANGUAGE_RTL) {
	$iecss .= '<style type="text/css" media="all">@import "' . base_path() . path_to_theme() . '/fix-ie-rtl.css";</style>';
    }

    return $iecss;
}

//function phptemplate_menu_tree($tree,$menu_name="") {
//     return ('<ul class="menu menu-'.$menu_name.' ">'. $tree .'</ul>');
//}

function menu_tree_full($menu_name = 'navigation') {



    static $menu_output = array();


    if (!isset($menu_output[$menu_name])) {

	$tree = menu_find_active_trail(menu_tree_all_data($menu_name));

	$menu_output[$menu_name] = menu_tree_output($tree);
    }

    return $menu_output[$menu_name];
}

/**

 * Wrapper function

 */
function menu_find_active_trail(&$menu_tree) {

    $item = menu_get_item();

    _menu_find_active_trail($menu_tree, $item);

    return $menu_tree;
}

/**

 * Recursive function to find the active menu and the active trail in the given tree.

 */
function _menu_find_active_trail(&$menu_tree, $item) {

    $level_is_expanded = FALSE;

    foreach ($menu_tree as &$menu_item) {

	$link = &$menu_item['link'];

	if ($link['href'] == $item['href']) { // Found the exact location in the tree
	    $link['active'] = TRUE;

	    $link['in_active_trail'] = TRUE;

	    return true;
	} else {

	    if ($link['has_children']) {

		$result = _menu_find_active_trail($menu_item['below'], $item);

		$link['in_active_trail'] = $result;

		if ($result)
		    $level_is_expanded = TRUE;
	    }
	}
    }

    return $level_is_expanded;
}

function THEMENAME_preprocess_page(&$vars) {
 

// Titles are ignored by content type when they are not desired in the design.
  $vars['original_title'] = $vars['title'];
  if (!empty($vars['node']) && in_array($vars['node']->type, array('page', 'story'))) {
    $vars['title'] = '';
  }
}