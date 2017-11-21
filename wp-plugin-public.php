<?php
class WP_Plugin_Public {
	private $errors = array();

	public function action_enqueue_styles_scripts() {
		wp_enqueue_style('wp-plugin', WP_PLUGIN_ASSETS_URL . 'css/wp-plugin.css', array(), true);
		wp_enqueue_script('wp-plugin', WP_PLUGIN_ASSETS_URL . 'js/wp-plugin.js', array('jquery'), true, true);
	}

	public function action_add_ajax_url() {
		$html = '<script type="text/javascript">';
		$html .= 'var ajaxUrl = "' . admin_url('admin-ajax.php') . '"';
		$html .= '</script>';
 
		echo $html;
	}

	public function action_do_output_buffering() {
        	ob_start();
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
