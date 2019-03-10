<?php
	/**
	 * The file contains a base class for plugin activators.
	 *
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright (c) 2018, Webcraftic Ltd
	 *
	 * @package factory-core
	 * @since 1.0.0
	 */
	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('Wbcr_Factory410_Activator') ) {
		/**
		 * Plugin Activator
		 *
		 * @since 1.0.0
		 */
		abstract class Wbcr_Factory410_Activator {

			/**
			 * Curent plugin.
			 * @var Wbcr_Factory410_Plugin
			 */
			public $plugin;

			public function __construct(Wbcr_Factory410_Plugin $plugin)
			{
				$this->plugin = $plugin;

			}

			public function activate()
			{
			}

			public function deactivate()
			{
			}

			public function update()
			{
			}
		}
	}