<?php if ( ! defined( 'ABSPATH' ) ) exit;
	
	//* Shortcode
	add_shortcode('Wow-Modal-Windows', 'show_wow_modal_windows_free');
	function show_wow_modal_windows_free($atts) {
		extract(shortcode_atts(array('id' => ""), $atts));		
		global $wpdb;
		$table = $wpdb->prefix . "modalsimple";    
		$sSQL = $wpdb->prepare("select * from $table WHERE id = %d", $id);
		$arrresult = $wpdb->get_results($sSQL); 	
		if (count($arrresult) > 0) {
			foreach ($arrresult as $key => $val) {			
				ob_start();
				include( 'partials/public.php' );
				$path_style = WOW_MWP_DIR.'/asset/modal/css/style-'.$val->id.'.css';
				$path_script = WOW_MWP_DIR.'/asset/modal/js/script-'.$val->id.'.js';
				$file_style = WOW_MWP_DIR.'/admin/partials/modal/generator/style.php';
				$file_script = WOW_MWP_DIR.'/admin/partials/modal/generator/script.php';
				if (file_exists($file_style) && !file_exists($path_style)){
					ob_start();
					include ($file_style);
					$content_style = ob_get_contents();
					ob_end_clean();
					file_put_contents($path_style, $content_style);
				}			
				if (file_exists($file_script) && !file_exists($path_script)){
					ob_start();
					include ($file_script);
					$content_script = ob_get_contents();
					$packer = new JavaScriptPacker($content_script, 'Normal', true, false);
					$packed = $packer->pack();
					ob_end_clean();
					file_put_contents($path_script, $packed);				
				}			
				
				$popup = ob_get_contents();
				ob_end_clean();
				
				if ($val->use_cookies == 'yes'){
					$namecookie = 'wow-modal-id-'.$val->id;
					if (!isset($_COOKIE[$namecookie])){					
						$popupcookie = true;
						wp_enqueue_script( WOW_MWP_BASENAME.'-cookie', plugin_dir_url( __FILE__ ) . 'js/jquery.cookie.js', array( 'jquery' ), WOW_MWP_VERSION);
					}
					else {
						$popupcookie = false;
					}					
				}
				if ($val->use_cookies == 'no'){
					$popupcookie = true;
				}				
				
				if ($popupcookie == true) {
					echo $popup;
					if (file_exists($path_style)) {
						wp_enqueue_style( WOW_MWP_BASENAME.'-style-'.$val->id, WOW_MWP_URL. 'asset/modal/css/style-'.$val->id.'.css', null, WOW_MWP_VERSION);	
					}
					if (file_exists($path_script)) {					
						wp_enqueue_script( WOW_MWP_BASENAME.'-script-'.$val->id, WOW_MWP_URL. 'asset/modal/js/script-'.$val->id.'.js', array( 'jquery' ), WOW_MWP_VERSION );
					}					
					wp_enqueue_style( WOW_MWP_BASENAME.'-style', plugin_dir_url( __FILE__ ) . 'css/style.css', null, WOW_MWP_VERSION);
					wp_enqueue_style( WOW_MWP_BASENAME.'-font-awesome', WOW_MWP_URL . 'asset/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
				}
			}
			
			} else {		
			echo "<p><strong>No Records</strong></p>";        
		}  
		
		return ;
	}
	
