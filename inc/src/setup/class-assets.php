<?php
/**
 * Manage theme static files.
 *
 * @package Aztec
 */

namespace Aztec\Setup;

use Aztec\Base;
use DI\Container;

/**
 * Manage application styles and scripts.
 */
class Assets extends Base {
	/**
	 * Assets current version.
	 *
	 * @var string
	 */
	const VERSION = '0.1';

	/**
	 * Init.
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_styles' ), 1 );
		add_action( 'wp_enqueue_scripts', $this->callback( 'enqueue_script' ) );

		add_action( 'enqueue_block_editor_assets', $this->callback( 'enqueue_block_editor_assets' ) );
	}

	/**
	 * Return the assets directory url.
	 *
	 * @param  string $path File path.
	 * @return string
	 */
	private function assets_uri( $path ) {
		return getenv( 'ASSETS_URL' ) . '/' . trim( $path, '/' );
	}

	/**
	 * Load application CSS.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'aztec-env', $this->assets_uri( 'app.css' ), [], self::VERSION );
	}

	/**
	 * Load application JS.
	 */
	public function enqueue_script() {
		wp_enqueue_script( 'aztec-env-vendor', $this->assets_uri( 'vendor.js' ), [ 'jquery' ], self::VERSION, true );
		wp_enqueue_script( 'aztec-env-app', $this->assets_uri( 'app.js' ), [], self::VERSION, true );
		wp_localize_script( 'aztec-env-app', 'aztec_env', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	/**
	 * Enqueue block editor assets.
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_script( 'aztec-env-vendor', $this->assets_uri( 'vendor.js' ), [], self::VERSION, true );
		wp_enqueue_script( 'aztec-env-editor', $this->assets_uri( 'editor.js' ), [], self::VERSION, true );

		wp_enqueue_style( 'aztec-env-editor', $this->assets_uri( 'editor.css' ), [], self::VERSION );
	}
}
