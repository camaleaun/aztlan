<?php
/**
 * Assets class
 *
 * @package Aztec
 */

namespace Aztec\Setup;

use Aztec\Base;

/**
 * Add Scripts and Styles
 */
class Assets extends Base {
	/**
	 * Add hooks
	 */
	public function init() {
		add_action( 'enqueue_block_editor_assets', $this->callback( 'enqueue_block_editor_assets' ) );
		add_action( 'init', $this->callback( 'register_scripts' ) );
		add_action( 'init', $this->callback( 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_styles' ), 1 );
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_scripts' ) );
	}

	/**
	 * Get assets URI
	 *
	 * @param  string $path File path.
	 * @return string
	 */
	private function assets_uri( $path ) {
		return getenv( 'ASSETS_URL' ) . '/' . trim( $path, '/' );
	}

	/**
	 * Register all application scripts
	 */
	public function register_scripts() {
		wp_register_script( 'aztlan-editor', $this->assets_uri( 'editor.js' ), [], self::VERSION, true );
		wp_register_script( 'aztlan-vendor', $this->assets_uri( 'vendor.js' ), array( 'jquery' ), self::VERSION, true );
		wp_register_script( 'aztlan', $this->assets_uri( 'app.js' ), array(), self::VERSION, true );
	}

	/**
	 * Register all application styles
	 */
	public function register_styles() {
		wp_register_style( 'aztlan-editor', $this->assets_uri( 'editor.css' ), [], self::VERSION );
		wp_register_style( 'aztlan', $this->assets_uri( 'app.css' ), array(), self::VERSION );
	}

	/**
	 * Set the translation for scripts that use wp.i18n
	 */
	public function set_script_translations() {
		wp_set_script_translations( 'aztlan-editor', 'aztlan', ABSPATH . '../../assets/languages' );
	}

	/**
	 * Load website styles
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'aztlan' );
	}

	/**
	 * Load website scripts
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'aztlan-vendor' );
		wp_enqueue_script( 'aztlan' );
	}

	/**
	 * Enqueue block editor assets
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script( 'aztlan-vendor' );
		wp_enqueue_script( 'aztlan-editor' );

		wp_enqueue_style( 'aztlan-editor' );
	}
}
