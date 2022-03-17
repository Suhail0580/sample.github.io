<?php

/**
 *
 * @package   DoctreatApp Core
 * @author    amentotech
 * @link      https://codecanyon.net/user/amentotech/portfolio
 * @since 1.0
 */

function android_get_video_data($video_url){
	if( !empty( $video_url ) ) {
		$height = 300;
		$width  = 450;
		$post_video = $video_url;
		$url = parse_url( $post_video );
		$videodata	= '';
		if (isset($url['host']) && ( $url['host'] == 'vimeo.com' || $url['host'] == 'player.vimeo.com')) {
			$content_exp = explode("/", $post_video);
			$content_vimo = array_pop($content_exp);
			$videodata .= '<iframe width="' . $width . '" height="' . $height . '" src="https://player.vimeo.com/video/' . $content_vimo . '"></iframe>';
		} elseif (isset($url['host']) && $url['host'] == 'soundcloud.com') {
			$video = wp_oembed_get($post_video, array('height' => $height));
			$search = array('webkitallowfullscreen', 'mozallowfullscreen', 'frameborder="no"', 'scrolling="no"');
			$video = str_replace($search, '', $video);
			$videodata .= str_replace('&', '&amp;', $video);
		} else {
			$content = str_replace(array('watch?v=', 'http://www.dailymotion.com/'), array('embed/', '//www.dailymotion.com/embed/'), $post_video);
			$videodata .= '<iframe width="' . $width . '" height="' . $height . '" src="' . $content . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		
		return $videodata;
	}
}

/**
 * @Demo Ready
 * @return {}
 */
if (!function_exists('doctreat_is_demo_api')) {
	function doctreat_is_demo_api($message=''){
		$json 		= array();
		$message	= !empty( $message ) ? $message : esc_html__("Sorry! you are restricted to perform this action on demo site.",'doctreat_api' );
		
		/*if( isset( $_SERVER["SERVER_NAME"] ) && $_SERVER["SERVER_NAME"] === 'houzillo.com' ){
			$json['type']	    =  "demo";
			$json['message']	=  $message;
			echo json_encode( $json );
			exit();
		}*/
	}
}

/**
 * @Authantication
 * @return {}
 */
if (!function_exists('doctreat_api_auth')) {
	function doctreat_api_auth($request){
		global $theme_settings;
		return true;
		$json 				= array();
		$key				= !empty( $request['key'] ) ? ( $request['key'] ) : '';
		$doctreat_api    	= !empty($theme_settings['doctreat_api_token']) ? $theme_settings['doctreat_api_token'] : '';
		
		if( empty($doctreat_api) ){
			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('API authorization tokey is not added yet.','doctreat_api');
			return new WP_REST_Response($json, 203);
		} else if( $key != $doctreat_api ){
			$json['type'] 		= 'error';
			$json['message'] 	= esc_html__('Unauthorized API key','doctreat_api');
			return new WP_REST_Response($json, 203);
		} else {
			//do nothing
		}
	}
}

/**
 * @SettermArray
 * @return []
 */
if (!function_exists('set_terms_array')) {
    function set_terms_array($arr_data = array())
    {
        $data = array();
        if (!empty($arr_data)) {
            if (is_array($arr_data)) {
                foreach ($arr_data as $val) {
                    $data[] = array(
                        'id' => $val->term_id,
                        'name' => $val->name,
                        'slug' => $val->slug,
                    );
                }
            } else {
                $data['id'] = $arr_data->term_id;
                $data['name'] = $arr_data->name;
                $data['slug'] = $arr_data->slug;
            }
        }

        return $data;
    }
}