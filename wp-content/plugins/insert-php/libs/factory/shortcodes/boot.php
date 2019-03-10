<?php
	/**
	 * Factory Shortcodes
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package factory-shortcodes
	 * @since 1.0.0
	 */

	if( defined('FACTORY_SHORTCODES_325_LOADED') ) {
		return;
	}
	define('FACTORY_SHORTCODES_325_LOADED', true);

	define('FACTORY_SHORTCODES_325_DIR', dirname(__FILE__));

	#comp merge
	require(FACTORY_SHORTCODES_325_DIR . '/shortcodes.php');
	require(FACTORY_SHORTCODES_325_DIR . '/shortcode.class.php');
	#endcomp
