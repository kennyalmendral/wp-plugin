<?php
class WP_Plugin {
	protected $plugin_slug;
	protected $version;

	protected $actions;
	protected $filters;
	protected $shortcodes;

	public function __construct() {
		$this->plugin_slug = 'wp_plugin';
		$this->version = '1.0.0';

		$this->actions = array();
		$this->filters = array();
		$this->shortcodes = array();

		$this->load_dependencies();
		$this->define_hooks();
	}

	private function get_version() {
		return $this->version;
	}

	private function load_dependencies() {
		require_once WP_PLUGIN_PLUGIN_PATH . 'wp-plugin-admin.php';
		require_once WP_PLUGIN_PLUGIN_PATH . 'wp-plugin-public.php';
	}

	private function define_hooks() {
		$admin = new WP_Plugin_Admin($this->get_version());

		$this->add_action('admin_menu', $admin, 'action_add_menu_option');
		$this->add_action('admin_enqueue_scripts', $admin, 'action_enqueue_styles_scripts');
		
		$this->add_action('widgets_init', $admin, 'action_register_sidebar');
		$this->add_action('widgets_init', $admin, 'action_register_widgets');

		$public = new WP_Plugin_Public($this->get_version());

		$this->add_action('wp_enqueue_scripts', $public, 'action_enqueue_styles_scripts');
		$this->add_action('wp_head', $public, 'action_add_ajax_library');
		$this->add_action('init', $public, 'action_do_output_buffering');
	}

	public function activate() {
	}

	public function deactivate() {
	}

	private function add_action($hook, $component, $callback, $priority = null, $accepted_args = null) {
		$this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
	}

	private function add_filter($hook, $component, $callback, $priority = null, $accepted_args = null) {
		$this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
	}

	private function add_shortcode($hook, $component, $callback, $priority = null, $accepted_args = null) {
		$this->shortcodes = $this->add($this->shortcodes, $hook, $component, $callback, $priority, $accepted_args);
	}

	private function add($hooks, $hook, $component, $callback, $priority = null, $accepted_args = null) {
		$hooks[] = array(
			'hook' => $hook,
			'component' => $component,
			'callback' => $callback,
			'priority' => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;
	}

	public function run() {
		foreach ($this->filters as $hook) {
			add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
		}

		foreach($this->actions as $hook) {
			add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
		}

		foreach($this->shortcodes as $hook) {
			add_shortcode($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
		}
	}
}
?>
