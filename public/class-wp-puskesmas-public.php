<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/rifqiandhika/
 * @since      1.0.0
 *
 * @package    Wp_Puskesmas
 * @subpackage Wp_Puskesmas/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Puskesmas
 * @subpackage Wp_Puskesmas/public
 * @author     HellQiii <rifqismurf50@gmail.com>
 */
class Wp_Puskesmas_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Puskesmas_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Puskesmas_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-puskesmas-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Puskesmas_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Puskesmas_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-puskesmas-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax_puskesmas', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));

	}
	public function cek_gizi(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-puskesmas-cek-gizi.php';
	}
	public function cek_gizi_umum(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-puskesmas-cek-gizi-umum.php';

	}

	function cek_gizi_ajax(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil simpan data cek gizi!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( WP_PUSKESMAS_APIKEY )) {
			$cek = $wpdb->get_var($wpdb->prepare('
				SELECT
					id
				FROM cek_gizi
				WHERE id_user=%d
					AND usia=%s
					AND bulan=%s
					AND tahun=%d
			', $_POST['id_user'], $_POST['usia'], $_POST['bulan'], $_POST['tahun']));
			$data = array(
				'id_user' => $_POST['id_user'],
				'nama' => $_POST['nama'],
				'usia' => $_POST['usia'],
				'tinggi' => $_POST['tinggi'],
				'berat' => $_POST['berat'],
				'ket_tinggi' => $_POST['ket_tinggi'],
				'ket_berat' => $_POST['ket_berat'],
				'update_at' => date('Y-m-d H:i:s'),
				'bulan' => $_POST['bulan'],
				'tahun' => $_POST['tahun']
			);
			if(!empty($cek)){
				$wpdb->update('cek_gizi', $data, array('id' => $cek));
			}else{
				$wpdb->insert('cek_gizi', $data);
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}
}
