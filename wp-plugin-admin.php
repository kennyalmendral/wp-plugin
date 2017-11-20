<?php
class WP_Plugin_Admin {
	private $errors = array();

	public function action_enqueue_styles_scripts() {
		wp_enqueue_style('wp-plugin-admin', WP_PLUGIN_ASSETS_URL . 'css/wp-plugin-admin.css', array(), true);
		wp_enqueue_script('wp-plugin-admin', WP_PLUGIN_ASSETS_URL . 'js/wp-plugin-admin.js', array('jquery'), true, true);
	}

	public function action_register_sidebar() {
		register_sidebar(array(
			'name' => 'WP Plugin Widgets',
			'id' => 'wp-plugin-widgets',
			'description' => 'Widgets area for WP Plugin',
			'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		));
	}

	public function action_register_widgets() {
	}

	public function action_add_menu_option() {
		add_menu_page('WP Plugin', 'WP Plugin', 'manage_options', 'wp-plugin', array($this, 'index'), 'dashicons-admin-plugins', 3);
	}

	function index() {
		if ( ! current_user_can('manage_options')
			wp_die('You do not have sufficient permissions to access this page.');

		require_once WP_PLUGIN_VIEWS_PATH . 'admin/index.php';
	}

	public function show_errors_if_exist() {
		if ( ! empty($this->errors)) {
			echo '<div class="errors">';
				echo '<h5><i class="fa fa-exclamation-triangle"></i> There were error(s) found. Please try again.</h5>';
				echo '<ul class="list-unstyled">';
					foreach ($this->errors as $error)
						echo "<li>* $error</li>";
				echo '</ul>';
			echo '</div>';
		}
	}

	public static function redirect_to($url) {
		wp_redirect(WP_PLUGIN_ROOT_PATH . $url);
		exit;
	}
}
?>
