<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/D-Heap/instapost
 * @since      1.0.0
 *
 * @package    Insta_Post
 * @subpackage Insta_Post/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Insta_Post
 * @subpackage Insta_Post/admin
 * @author     Mina Sato <mina@d-heap.co.uk>
 */
class InstaPost_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/insta-post-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'instagram-js', plugin_dir_url( __FILE__ ) . 'js/insta-post-admin.js', array(), '1.0.0', true );
		wp_localize_script( 'instagram-js', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );


	}

	public function get_insta_post_action() {
	    
	    $insta_post_url = sprintf('https://api.instagram.com/oembed/?url=%s', $_POST['instapost']);

	    $curl = curl_init();
	    $options = array(
	      CURLOPT_URL => $insta_post_url,
	      CURLOPT_RETURNTRANSFER => 1,
	      CURLOPT_VERBOSE => 1,
	      CURLOPT_SSL_VERIFYPEER => false,
	      CURLOPT_CONNECTTIMEOUT => 30
	    );
	    curl_setopt_array($curl, $options);
	    $response = curl_exec($curl);

	    $json = json_decode($response);

	    // Get datetime from embed code
	    $datetime = preg_match_all('/datetime=\\"(.*)\\"/', $json->html, $matches);
	    $json->datetime = $matches[1][0];


	    // Add links to mentions and hashtags
	    $tags = preg_match_all('/((#|@)(?:\[[^\]]+\]|\S+))/', $json->title, $matches);

	    foreach ($matches[0] as $key => $match) {

	    	$tag  = strtolower(str_replace(substr($match, 0, 1), '', $match));
	    	$link = strstr($match, '#') ? sprintf('<a href="https://instagram.com/explore/tags/%s">%s</a>', $tag, $match) : sprintf('<a href="https://instagram.com/%s">%s</a>', $tag, $match);
	    	
	    	$json->title = str_replace($match, $link, $json->title);
	    }


	    echo json_encode($json);

	    wp_die();
	}

}
