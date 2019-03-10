<?php
	/**
	 * Factory Plugin
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package core
	 * @since 1.0.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( defined('FACTORY_410_LOADED') ) {
		return;
	}
	define('FACTORY_410_LOADED', true);

	define('FACTORY_410_VERSION', '4.0.9');

	define('FACTORY_410_DIR', dirname(__FILE__));
	define('FACTORY_410_URL', plugins_url(null, __FILE__));

	load_plugin_textdomain('wbcr_factory_410', false, dirname(plugin_basename(__FILE__)) . '/langs');

	#comp merge
	require_once(FACTORY_410_DIR . '/includes/functions.php');
	require_once(FACTORY_410_DIR . '/includes/request.class.php');
	require_once(FACTORY_410_DIR . '/includes/base.class.php');

	require_once(FACTORY_410_DIR . '/includes/assets-managment/assets-list.class.php');
	require_once(FACTORY_410_DIR . '/includes/assets-managment/script-list.class.php');
	require_once(FACTORY_410_DIR . '/includes/assets-managment/style-list.class.php');

	require_once(FACTORY_410_DIR . '/includes/plugin.class.php');

	require_once(FACTORY_410_DIR . '/includes/activation/activator.class.php');
	require_once(FACTORY_410_DIR . '/includes/activation/update.class.php');
	#endcomp
