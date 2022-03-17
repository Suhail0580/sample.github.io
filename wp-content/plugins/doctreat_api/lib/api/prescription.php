<?php
/**
 * Manage Prescription
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */

if (!class_exists('Doctreat_Prescription_Routes')) {

    class Doctreat_Prescription_Routes extends WP_REST_Controller{

        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'prescription';
			
			//get appointment listings
			register_rest_route($namespace, '/' . $base . '/create_prescription',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'create_medical_prescription'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			register_rest_route($namespace, '/' . $base . '/download_prescription',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'download_prescription'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );

			/* get saved prescription */
            register_rest_route($namespace, '/' . $base . '/saved_prescription',
                array(
                    array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'prescription_saved_data'),
                        'args' 		=> array(),
                        'permission_callback' => '__return_true',
                    ),
                )
            );

		}

        /**
         * get saved Precription
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function prescription_saved_data($request)
        {
            if (function_exists('doctreat_is_demo_api')) {
                doctreat_is_demo_api();
            } //if demo site then prevent
            $booking_id         = !empty($request['booking_id']) ? intval($request['booking_id']) : "";
            $prescription_id	= get_post_meta( $booking_id, '_prescription_id', true );
            $json               = array();

            if(empty($booking_id) || get_post_status($booking_id) != 'publish'){
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Something went wrong','doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if( !empty($booking_id) && !empty($prescription_id) ) {
                $prescription	        = get_post_meta( $prescription_id, '_detail', true );
                $bk_username	        = !empty($prescription['_patient_name']) ? $prescription['_patient_name'] : '';
                $bk_phone		        = !empty($prescription['_phone']) ? $prescription['_phone'] : '';
                $age			        = !empty($prescription['_age']) ? $prescription['_age'] : '';
                $gender			        = !empty($prescription['_gender']) ? $prescription['_gender'] : '';
                $patient_address	    = !empty($prescription['_address']) ? $prescription['_address'] : '';
                $location 			    = apply_filters('doctreat_get_tax_query',array(), $prescription_id, 'locations','');
                $patient_location	    = !empty( $location[0]->term_id ) ? $location[0] : '';
                $marital_status_id      = !empty($prescription['_marital_status']) ? $prescription['_marital_status'] : '';
                $marital_status         = !empty($marital_status_id) ? get_term_by('id', $marital_status_id, 'marital_status') : '';
                $childhood_illness_ids	= !empty($prescription['_childhood_illness']) ? $prescription['_childhood_illness'] : array();
                $childhood_illness      = !empty($childhood_illness_ids) ? get_terms(array('taxonomy' => 'childhood_illness','hide_empty' => false,'include' => $childhood_illness_ids)) : array();
                $disease_ids	        = wp_get_post_terms( $prescription_id, 'diseases', array( 'fields' => 'ids' ) );
                $disease                = !empty($disease_ids) ? get_terms(array('taxonomy' => 'diseases','hide_empty' => false,'include' => $disease_ids)) : array();
                $laboratory_test_ids    = wp_get_post_terms( $prescription_id, 'laboratory_tests', array( 'fields' => 'ids' ) );
                $laboratory_test        = !empty($laboratory_test_ids) ? get_terms(array('taxonomy' => 'laboratory_tests','hide_empty' => false,'include' => $laboratory_test_ids)) : array();
                $vital_signs		    = !empty($prescription['_vital_signs']) ? $prescription['_vital_signs'] : array();
                $medical_history	    = !empty($prescription['_medical_history']) ? $prescription['_medical_history'] : '';
                $medicines			    = !empty($prescription['_medicine']) ? $prescription['_medicine'] : array();

                /* set data for vital sign */
                $vital = array();
                if(!empty($vital_signs)) {
                    foreach ($vital_signs as $vital_key => $vital_values) {
                        $vital_val              = !empty($vital_values['value']) ? $vital_values['value'] : '';
                        $vital_sign_selected    = get_term_by('id', $vital_key, 'vital_signs');
                        $vital_sign_selected    = !empty($vital_sign_selected) ? $vital_sign_selected : array();
                        $vital[] = array(
                            "value" => $vital_val,
                            "vital" => set_terms_array($vital_sign_selected),
                        );
                    }
                }

                /* set data for medication */
                $medicine_arr = array();
                if(!empty($medicines)) {
                    foreach ($medicines as $medicine_key => $medicine_values) {
                        $name_val                   = !empty($medicine_values['name']) ? $medicine_values['name'] : '';
                        $medicine_types_val         = !empty($medicine_values['medicine_types']) ? $medicine_values['medicine_types'] : '';
                        $medicine_type_selected     = !empty($medicine_types_val) ? get_term_by('id', $medicine_types_val, 'medicine_types') : '';
                        $medicine_duration_val      = !empty($medicine_values['medicine_duration']) ? $medicine_values['medicine_duration'] : '';
                        $medicine_duration_selected = !empty($medicine_duration_val) ? get_term_by('id', $medicine_duration_val, 'medicine_duration') : '';
                        $medicine_usage_val         = !empty($medicine_values['medicine_usage']) ? $medicine_values['medicine_usage'] : '';
                        $medicine_usage_selected    = !empty($medicine_usage_val) ?  get_term_by('id', $medicine_usage_val, 'medicine_usage') : '';
                        $detail_val                 = !empty($medicine_values['detail']) ? $medicine_values['detail'] : '';
                        $medicine_arr[] = array(
                            "name"              => $name_val,
                            "medicine_types"    => set_terms_array($medicine_type_selected),
                            "medicine_duration" => set_terms_array($medicine_duration_selected),
                            "medicine_usage"    => set_terms_array($medicine_usage_selected),
                            "detail"            => $detail_val,
                        );
                    }
                }

                $json['patient_info']['patient_name']       = $bk_username;
                $json['patient_info']['phone']              = $bk_phone;
                $json['patient_info']['age']                = $age;
                $json['patient_info']['address']            = $patient_address;
                $json['patient_info']['location']           = set_terms_array($patient_location);
                $json['patient_info']['gender']             = $gender;
                $json['patient_info']['marital_status']     = set_terms_array($marital_status);

                $json['patient_info']['childhood_illness']  = set_terms_array($childhood_illness);
                $json['patient_info']['diseases']           = set_terms_array($disease);
                $json['patient_info']['laboratory_test']    = set_terms_array($laboratory_test);
                $json['patient_info']['medical_history']    = $medical_history;
                $json['patient_info']['vital_sign']         = $vital;
                $json['patient_info']['medication']         = $medicine_arr;


                return new WP_REST_Response($json, 200);
            }

        }

		/**
         * Download Precription
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function download_prescription($request){
			global $theme_settings,$wpdb;

			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$required			= array();
			$booking_id			= !empty( $request['booking_id'] ) ? $request['booking_id']  : '';

			$html				= apply_filters('doctreat_pdf',$booking_id);
			
			$json['html'] 		= $html;
			$json['type'] 		= 'success';
			$json['message'] 	= esc_html__('Thank you for downloading prescription','doctreat_api');        
			return new WP_REST_Response($json, 200);
			
		}
		
		/**
         * Create Precription
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function create_medical_prescription($request){
			global $theme_settings,$wpdb;

			if( function_exists('doctreat_is_demo_api') ) { 
				doctreat_is_demo_api() ;
			} //if demo site then prevent
			
			$json 				= array();
			$required			= array();
			
			$user_id	= !empty( $request['user_id'] ) ? $request['user_id']  : '';

            $fields = array(
                'patient_name'      => esc_html__('Name is required.', 'doctreat_api'),
                'medical_history'   => esc_html__('Medical history is required.', 'doctreat_api'),
                'booking_id'        => esc_html__('Booking ID is required.', 'doctreat_api')
            );

			foreach($fields as $key => $val ) {
				if( empty( $request[$key] ) ){
					$json['type'] 		= 'error';
					$json['message'] 	= $val;
					return new WP_REST_Response($json, 203);
				 }
			}

			$booking_id				= !empty($request['booking_id']) ? sanitize_text_field($request['booking_id']) : '';
			$patient_name			= !empty($request['patient_name']) ? sanitize_text_field($request['patient_name']) : '';
			$phone					= !empty($request['phone']) ? sanitize_text_field($request['phone']) : '';
			$age					= !empty($request['age']) ? sanitize_text_field($request['age']) : '';
			$address				= !empty($request['address']) ? sanitize_text_field($request['address']) : '';
			$location				= !empty($request['location']) ? doctreat_get_term_by_type('slug',sanitize_text_field($request['location']),'locations' ) : '';
			$gender					= !empty($request['gender']) ? sanitize_text_field($request['gender']) : '';
			$marital_status			= !empty($request['marital_status']) ? ($request['marital_status']) : '';
			$childhood_illness		= !empty($request['childhood_illness']) ? ($request['childhood_illness']) : array();
			$laboratory_tests		= !empty($request['laboratory_tests']) ? ($request['laboratory_tests']) : array();
			$vital_signs			= !empty($request['vital_signs']) ? ($request['vital_signs']) : '';
			$medical_history		= !empty($request['medical_history']) ? sanitize_text_field($request['medical_history']) : '';
			$medicine				= !empty($request['medicine']) ? ($request['medicine']) : array();

			$diseases				= !empty($request['diseases']) ? ($request['diseases']) : array();
			$medical_history		= !empty($request['medical_history']) ? sanitize_textarea_field($request['medical_history']) : '';

			$doctor_id				= get_post_meta( $booking_id, '_doctor_id', true );
			$doctor_id				= doctreat_get_linked_profile_id($doctor_id,'post');
			$hospital_id			= get_post_meta( $booking_id, '_hospital_id', true );

			$prescription_id		= get_post_meta( $booking_id, '_prescription_id', true );
			$am_booking				= get_post_meta( $booking_id, '_am_booking', true );
			$patient_id				= get_post_field( 'post_author', $booking_id );

			$myself					= !empty($am_booking['myself']) ? $am_booking['myself'] : '';

			if( !empty($doctor_id) && ($doctor_id != $user_id) ){
				$json['type'] 		= 'error';
				$json['message'] 	= esc_html__('You are not allwod to add prescription.','doctreat_api');        
				return new WP_REST_Response($json, 203);
			}

			/* arrange array for avoid null from app side data */
            $vital_signs_arr = array();
			if(!empty($vital_signs) && is_array($vital_signs)){
			    foreach ($vital_signs as $key=>$sign){
			        if(!empty($sign)){
                        $vital_signs_arr[$key] = array(
                            'name'  => $sign['name'],
                            'value' => $sign['value']
                        );
                    }
                }
            }

			$post_array					= array();
			$post_array['post_title']	=	$patient_name;
			if( empty($prescription_id) ){
				$post_array['post_type']	= 'prescription';
				$post_array['post_status']	= 'publish';
				$prescription_id = wp_insert_post($post_array);
			} else {
				wp_update_post($post_array);
			}

			$post_meta  = array();
			if( !empty($laboratory_tests) ){
				$laboratory_tests_array	= array();
				foreach($laboratory_tests as $laboratory_test ){
					$term 	= doctreat_get_term_by_type( 'id',$laboratory_test, 'laboratory_tests','id' );
					if ( !empty($term) ) {
						$laboratory_tests_id	= $laboratory_test;
					} else {
						wp_insert_term($laboratory_test,'laboratory_tests');
						$term 					= doctreat_get_term_by_type( 'name',$laboratory_test, 'laboratory_tests','id' );
						$laboratory_tests_id	= !empty($term) ? $term : '';
					}

					if( !empty( $laboratory_tests_id ) ){
						$laboratory_tests_array[] = $laboratory_tests_id;
					}
				}
				if( !empty( $laboratory_tests_array ) ){
					wp_set_post_terms( $prescription_id, $laboratory_tests_array, 'laboratory_tests' );
				}
				$post_meta['_laboratory_tests']		= $laboratory_tests_array;
			}

			$post_meta['_patient_name']		= $patient_name;
			$post_meta['_phone']			= $phone;
			$post_meta['_age']				= $age;
			$post_meta['_address']			= $address;
			$post_meta['_location']			= $location;
			$post_meta['_gender']			= $gender;

			$post_meta['_marital_status']		= $marital_status;
			$post_meta['_childhood_illness']	= $childhood_illness;
			$post_meta['_vital_signs']			= $vital_signs_arr;
			$post_meta['_medical_history']		= $medical_history;
			$post_meta['_medicine']				= $medicine;
			$post_meta['_diseases']				= $diseases;

			$signs_keys		= !empty($vital_signs_arr) ? array_keys($vital_signs_arr) : array();
			$signs_keys		= !empty($signs_keys) ? array_unique($signs_keys): array();

			wp_set_post_terms( $prescription_id, array($location), 'locations' );
			wp_set_post_terms( $prescription_id, $signs_keys, 'vital_signs' );
			wp_set_post_terms( $prescription_id, $childhood_illness, 'childhood_illness' );
			wp_set_post_terms( $prescription_id, array($marital_status), 'marital_status' );
			wp_set_post_terms( $prescription_id, $diseases, 'diseases' );

			update_post_meta( $prescription_id, '_hospital_id',$hospital_id );
			update_post_meta( $prescription_id, '_medicine',$medicine );
			update_post_meta( $prescription_id, '_doctor_id',$doctor_id );
			update_post_meta( $prescription_id, '_booking_id',$booking_id );
			update_post_meta( $prescription_id, '_patient_id',$patient_id );
			update_post_meta( $prescription_id, '_myself',$myself );
			update_post_meta( $prescription_id, '_detail',$post_meta );

			update_post_meta( $prescription_id, '_childhood_illness',$childhood_illness );
			update_post_meta( $prescription_id, '_marital_status',$marital_status );
			update_post_meta( $booking_id, '_prescription_id',$prescription_id );

			$json['type'] 	 	= 'success';
			$json['message'] 	= esc_html__('Prescription has been updated successfully.', 'doctreat_api');

			return new WP_REST_Response($json, 200);
			
		}	

    }
}

add_action('rest_api_init',
function () {
	$controller = new Doctreat_Prescription_Routes;
	$controller->register_routes();
});
