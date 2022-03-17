<?php
/**
 * APP API to manage users
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat App
 *
 */
if (!class_exists('DoctreatApp_User_Route')) {

    class DoctreatApp_User_Route extends WP_REST_Controller
    {

        /**
         * Register the routes for the user.
         */
        public function register_routes()
        {
            $version    = '1';
            $namespace  = 'api/v' . $version;
            $base       = 'user';

            //user login
            register_rest_route($namespace, '/' . $base . '/do_login',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_items'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'user_login'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //user login
            register_rest_route($namespace, '/' . $base . '/do_logout',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'do_logout'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //get on call options
            register_rest_route($namespace, '/' . $base . '/get_oncall_options',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_booking_options'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //get on call options
            register_rest_route($namespace, '/' . $base . '/get_theme_settings',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_theme_settings'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //get access
            register_rest_route($namespace, '/' . $base . '/get_access',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_access'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //get packages
            register_rest_route($namespace, '/' . $base . '/get_packages',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_packages'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //get feedback options
            register_rest_route($namespace, '/' . $base . '/get_feedback_options',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_feedback_options'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            // Add feedback
            register_rest_route($namespace, '/' . $base . '/add_feedback',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'add_feedback'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //forgot password
            register_rest_route($namespace, '/' . $base . '/forgot_password',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_items'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'get_forgot_password'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            // For signup
            register_rest_route($namespace, '/' . $base . '/signup',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'signup'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            // For verification code
            register_rest_route($namespace, '/' . $base . '/account_verification',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'account_verification'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //User Reporting
            register_rest_route($namespace, '/' . $base . '/reporting',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array(&$this, 'get_items'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'reporting_user'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            //User specialities
            register_rest_route($namespace, '/' . $base . '/update_user_specialities',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array(&$this, 'update_user_specialities'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                )
            );

            // checkout page
            register_rest_route($namespace, '/' . $base . '/create_checkout_page',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array($this, 'create_checkout_page'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                ));

            // patient feedback to doctor
            register_rest_route($namespace, '/' . $base . '/patient_feedback',
                array(
                    array(
                        'methods'               => WP_REST_Server::READABLE,
                        'callback'              => array($this, 'patient_feedback'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                ));

            // send patient feedback to doctor
            register_rest_route($namespace, '/' . $base . '/patient_feedback',
                array(
                    array(
                        'methods'               => WP_REST_Server::CREATABLE,
                        'callback'              => array($this, 'patient_feedback_send'),
                        'args'                  => array(),
                        'permission_callback'   => '__return_true',
                    ),
                ));
        }

        /**
         * Send Feedback from patient to doctor
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function patient_feedback_send($request)
        {
            global $wpdb;
            $doctor_profile_id      = !empty($request['doctor_id']) ? intval($request['doctor_id']) : '';
            $patient_id             = !empty($request['patient_id']) ? intval($request['patient_id']) : '';
            $doctor_id              = doctreat_get_linked_profile_id($doctor_profile_id, 'post');
            $user_type              = apply_filters('doctreat_get_user_type', $patient_id);

            $contents               = !empty($request['feedback_description']) ? $request['feedback_description'] : '';
            $recommend              = !empty($request['feedback_recommend']) ? $request['feedback_recommend'] : '';
            $feedbackpublicly       = !empty($request['feedbackpublicly']) ? $request['feedbackpublicly'] : '';
            $waiting_time           = !empty($request['waiting_time']) ? $request['waiting_time'] : '';
            $reviews                = !empty($request['feedback']) ? $request['feedback'] : array();
            $review_title           = get_the_title($doctor_profile_id);

            if (empty($doctor_profile_id) || empty($patient_id)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Something went wrong.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* check user is patient */
            if (!empty($user_type) && $user_type != 'regular_users') {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You are not allowed to add feedback.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* description required */
            if (empty($contents)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Feedback description is required.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* recommendation required */
            if (empty($recommend)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Feedback recommendation is required.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* re-design reviews for use */
            $feedback_review = array();
            foreach ($reviews as $val) {
                foreach ($val as $inner_key => $inner_val) {
                    $feedback_review[$inner_key] = $inner_val;
                }
            }
            /* check this user can send feedback or not  */
            $user_reviews = array(
                'posts_per_page'    => 1,
                'post_type'         => 'reviews',
                'author'            => $doctor_id,
                'meta_key'          => '_user_id',
                'meta_value'        => $patient_id,
                'meta_compare'      => "=",
                'orderby'           => 'meta_value',
                'order'             => 'ASC',
            );

            $reviews_query = new WP_Query($user_reviews);
            $reviews_count = $reviews_query->post_count;

            if (isset($reviews_count) && $reviews_count > 0) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You have already submit a review.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            } else {
                $review_post = array(
                    'post_title'        => $review_title,
                    'post_status'       => 'publish',
                    'post_content'      => $contents,
                    'post_author'       => $doctor_id,
                    'post_type'         => 'reviews',
                    'post_date'         => current_time('Y-m-d H:i:s')
                );
                $post_id = wp_insert_post($review_post);

                /* Get the rating headings */
                $rating_evaluation          = doctreat_doctor_ratings();
                $rating_evaluation_count    = !empty($rating_evaluation) ? doctreat_count_items($rating_evaluation) : 0;

                $review_extra_meta  = array();
                $rating             = 0;
                $user_rating        = 0;

                if (!empty($rating_evaluation)) {
                    foreach ($rating_evaluation as $slug => $label) {
                        if (isset($feedback_review[$slug])) {
                            $review_extra_meta[$slug] = esc_html($feedback_review[$slug]);
                            update_post_meta($post_id, $slug, esc_html($reviews[$slug]));
                            $rating += (int)$feedback_review[$slug];
                        }
                    }
                }

                update_post_meta($post_id, '_user_id', $patient_id);
                update_post_meta($post_id, '_waiting_time', $waiting_time);
                update_post_meta($post_id, '_feedback_recommend', $recommend);
                update_post_meta($post_id, '_feedbackpublicly', $feedbackpublicly);

                if (!empty($rating)) {
                    $user_rating = $rating / $rating_evaluation_count;
                }

                $user_profile_id            = doctreat_get_linked_profile_id($patient_id);
                $user_rating                = number_format((float)$user_rating, 2, '.', '');
                $single_user_user_rating    = $user_rating;

                $review_meta = array(
                    'user_rating'       => $user_rating,
                    'user_from'         => $user_profile_id,
                    'user_to'           => $doctor_profile_id,
                    'review_date'       => current_time('Y-m-d H:i:s'),
                );
                $review_meta = array_merge($review_meta, $review_extra_meta);

                //Update post meta
                foreach ($review_meta as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }

                $table_review   = $wpdb->prefix . "posts";
                $table_meta     = $wpdb->prefix . "postmeta";

                $db_rating_query = $wpdb->get_row("
				SELECT p.ID,
				SUM( pm2.meta_value ) AS db_rating,
				count( p.ID ) AS db_total
				FROM " . $table_review . " p 
				LEFT JOIN " . $table_meta . " pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = 'user_to') 
				LEFT JOIN " . $table_meta . " pm2 ON (pm2.post_id = p.ID AND pm2.meta_key = 'user_rating')
				WHERE post_status = 'publish'
				AND pm1.meta_value = " . $doctor_profile_id . "
				AND p.post_type = 'reviews'
				", ARRAY_A);

                if (empty($db_rating_query)) {
                    $user_db_reviews['dc_average_rating']       = 0;
                    $user_db_reviews['dc_total_rating']         = 0;
                    $user_db_reviews['dc_total_percentage']     = 0;
                    $user_db_reviews['wt_rating_count']         = 0;
                } else {
                    $rating         = !empty($db_rating_query['db_rating']) ? $db_rating_query['db_rating'] / $db_rating_query['db_total'] : 0;
                    $user_rating    = number_format((float)$rating, 2, '.', '');

                    $user_db_reviews['dc_average_rating']   = $user_rating;
                    $user_db_reviews['dc_total_rating']     = !empty($db_rating_query['db_total']) ? $db_rating_query['db_total'] : '';
                    $user_db_reviews['dc_total_percentage'] = $user_rating * 20;
                    $user_db_reviews['dc_rating_count']     = !empty($db_rating_query['db_rating']) ? $db_rating_query['db_rating'] : '';
                }

                update_post_meta($doctor_profile_id, 'review_data', $user_db_reviews);
                update_post_meta($doctor_profile_id, 'rating_filter', $user_rating);

                $total_rating       = get_post_meta($doctor_profile_id, '_total_voting', true);
                $total_rating       = !empty($total_rating) ? $total_rating + 1 : 0;

                $total_recommend    = get_post_meta($doctor_profile_id, '_recommend', true);
                $total_recommend    = !empty($total_recommend) ? $total_recommend : 0;
                $total_recommend    = !empty($recommend) && $recommend === 'yes' ? $total_recommend + 1 : $total_recommend;

                update_post_meta($doctor_profile_id, '_recommend', $total_recommend);
                update_post_meta($doctor_profile_id, '_total_voting', $total_rating);

                if (class_exists('Doctreat_Email_helper')) {
                    if (class_exists('DoctreatFeedbackNotify')) {
                        $email_helper = new DoctreatFeedbackNotify();
                        $doctor_details             = !empty($doctor_id) ? get_userdata($doctor_id) : array();
                        $emailData                  = array();
                        $waiting_time_array         = doctreat_get_waiting_time();
                        $emailData['email']         = !empty($doctor_details->user_email) ? $doctor_details->user_email : '';
                        $emailData['user_name']     = !empty($user_profile_id) ? doctreat_full_name($user_profile_id) : '';
                        $emailData['doctor_name']   = !empty($doctor_profile_id) ? doctreat_full_name($doctor_profile_id) : '';
                        $emailData['waiting_time']  = !empty($waiting_time_array[$waiting_time]) ? esc_html($waiting_time_array[$waiting_time]) : '';
                        $emailData['recommend']     = !empty($recommend) ? ucfirst($recommend) : '';
                        $emailData['rating']        = !empty($single_user_user_rating) ? $single_user_user_rating : 0;
                        $emailData['description']   = sanitize_textarea_field($contents);

                        $email_helper->send_feedback_email_doctor($emailData);
                    }
                }

                $json['type']       = 'success';
                $json['message']    = esc_html__('Your feedback is successfully submitted.', 'doctreat');
                return new WP_REST_Response($json, 200);
            }

        }

        /**
         * Feedback from patient to doctor
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function patient_feedback($request)
        {
            global $theme_settings;
            $doctor_profile_id      = !empty($request['doctor_id']) ? intval($request['doctor_id']) : '';
            $doctor_id              = doctreat_get_linked_profile_id($doctor_profile_id, 'post');
            $patient_id             = !empty($request['patient_id']) ? intval($request['patient_id']) : '';
            $user_type              = apply_filters('doctreat_get_user_type', $patient_id);
            $waiting_times          = doctreat_get_waiting_time();
            $rating_headings        = doctreat_doctor_ratings();
            $metadata               = array();

            if (empty($doctor_profile_id) || empty($patient_id)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Something went wrong.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* check patient or not */
            if (!empty($user_type) && $user_type != 'regular_users') {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You are not allowed to add feedback.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* user complete one appointment */
            $metadata['_doctor_id']     = $doctor_profile_id;
            $bookings                   = doctreat_get_total_posts_by_multiple_meta('booking', 'publish', $metadata, $patient_id);
            $feedback_option            = !empty($theme_settings['feedback_option']) ? $theme_settings['feedback_option'] : '';
            if ($bookings == 0 && $feedback_option == 1) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You need to complete atleast 1 appointment to add feedback.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            /* waiting time */
            $time_wait = array();
            if (!empty($waiting_times) && is_array($waiting_times)) {
                foreach ($waiting_times as $key => $time) {
                    $time_wait[] = array(
                        'key'   => $key,
                        'time'  => $time,
                    );
                }
            }
            $array_data['waiting_time'] = $time_wait;

            /* recommended(yes/no) */
            $array_data['recommended'] = [
                array(
                    'key'       => 'yes',
                    'value'     => esc_html__('Yes', 'doctreat_api'),
                ),
                array(
                    'key'       => 'no',
                    'value'     => esc_html__('No', 'doctreat_api'),
                ),
            ];

            /* rating heading */
            $array_data['rating_data']          = !empty($rating_headings) ? $rating_headings : array();

            /* share experience string */
            $array_data['experience_string']    = esc_html__('Share Your Experience', 'doctreat_api');

            /* keep this public or not */
            $array_data['experience_string']    = esc_html__('Keep this feedback publicly anonymous.', 'doctreat_api');

            /* submit button text */
            $array_data['submit_btn']           = esc_html__('Submit Now', 'doctreat_api');

            return new WP_REST_Response($array_data, 200);

        }

        /**
         * Signup user for application
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function signup($request)
        {
            global $theme_settings;
            $verify_user        = !empty($theme_settings['verify_user']) ? $theme_settings['verify_user'] : '';
            $remove_location    = !empty($theme_settings['remove_location']) ? $theme_settings['remove_location'] : 'no';

            $json   = array();
            $item   = array();
            $items  = array();

            //Validation
            $validations = array(
                'first_name'        => esc_html__('First Name is required', 'doctreat_core'),
                'first_name'        => esc_html__('First Name is required', 'doctreat_core'),
                'last_name'         => esc_html__('Last Name is required.', 'doctreat_core'),
                'username'          => esc_html__('Username field is required.', 'doctreat_core'),
                'location'          => esc_html__('Location field is required', 'doctreat_core'),
                'password'          => esc_html__('Password field is required', 'doctreat_core'),
                'verify_password'   => esc_html__('Verify Password field is required.', 'doctreat_core'),
                'user_type'         => esc_html__('User type field is required.', 'doctreat_core'),
                'termsconditions'   => esc_html__('You should agree to terms and conditions.', 'doctreat_core'),
                'display_name'      => esc_html__('Your name field is required.', 'doctreat_core'),
            );

            //unset location if settings true
            if (!empty($remove_location) && $remove_location == 'yes') {
                unset($validations['location']);
            }

            //start validating
            foreach ($validations as $key => $value) {
                if (empty($request[$key])) {
                    $json['type']       = 'error';
                    $json['message']    = $value;
                    return new WP_REST_Response($json, 203);
                }

                //Validate email address
                if ($key === 'email') {
                    if (!is_email($request['email'])) {
                        $json['type']       = 'error';
                        $json['message']    = esc_html__('Please add a valid email address.', 'doctreat_core');
                        return new WP_REST_Response($json, 203);
                    }
                }

                if ($key === 'password') {
                    if (strlen($request[$key]) < 6) {
                        $json['type']       = 'error';
                        $json['message']    = esc_html__('Password length should be minimum 6', 'doctreat_core');
                        return new WP_REST_Response($json, 203);
                    }
                }


                if ($key === 'verify_password') {
                    if ($request['password'] != $request['verify_password']) {
                        $json['type']       = 'error';
                        $json['message']    = esc_html__('Password does not match.', 'doctreat_core');
                        return new WP_REST_Response($json, 203);
                    }
                }
            }

            $username       = !empty($request['username']) ? esc_attr($request['username']) : '';
            $first_name     = !empty($request['first_name']) ? esc_attr($request['first_name']) : '';
            $last_name      = !empty($request['last_name']) ? esc_attr($request['last_name']) : '';
            $email          = !empty($request['email']) ? esc_attr($request['email']) : '';
            $location       = !empty($request['location']) ? esc_attr($request['location']) : '';
            $password       = !empty($request['password']) ? esc_attr($request['password']) : '';
            $user_type      = !empty($request['user_type']) ? esc_attr($request['user_type']) : '';
            $display_name   = !empty($request['display_name']) ? esc_attr($request['display_name']) : $first_name;

            $username_exist = username_exists($username);
            $user_exists    = email_exists($email);

            if (!is_email($email)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Please add valid email address', 'doctreat_core');
                return new WP_REST_Response($json, 203);
            }

            if ($username_exist) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Username already registered', 'doctreat_core');
                return new WP_REST_Response($json, 203);
            }

            //check exists
            if ($user_exists) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('This email already registered', 'doctreat_core');
                return new WP_REST_Response($json, 203);
            }

            //Get user data from session

            //Session data validation
            if (empty($username)
                || empty($first_name)
                || empty($last_name)
                || empty($email)
                || empty($display_name)
            ) {


                $json['type']       = 'error';
                $json['message']    = esc_html__('Please add all the required fields', 'doctreat_core');
                return new WP_REST_Response($json, 203);
            }

            $post_type          = $user_type;
            $random_password    = $password;
            $user_nicename      = sanitize_title($display_name);

            $userdata = array(
                'user_login'    => $username,
                'user_pass'     => $random_password,
                'user_email'    => $email,
                'user_nicename' => $user_nicename,
                'display_name'  => $display_name
            );

            $user_identity = wp_insert_user($userdata);

            if (is_wp_error($user_identity)) {
                $json['type']       = "error";
                $json['message']    = esc_html__("Some error occurs, please try again later", 'doctreat_core');
                return new WP_REST_Response($json, 203);
            } else {
                global $wpdb;
                wp_update_user(array('ID' => esc_sql($user_identity), 'role' => esc_sql($user_type), 'user_status' => 1));

                $wpdb->update(
                    $wpdb->prefix . 'users', array('user_status' => 1), array('ID' => esc_sql($user_identity))
                );

                update_user_meta($user_identity, 'first_name', $first_name);
                update_user_meta($user_identity, 'last_name', $last_name);
                update_user_meta($user_identity, '_is_verified', 'no');
                update_user_meta($user_identity, 'show_admin_bar_front', false);

                //verification link
                $key_hash = md5(uniqid(openssl_random_pseudo_bytes(32)));
                update_user_meta($user_identity, 'confirmation_key', $key_hash);
                $protocol       = is_ssl() ? 'https' : 'http';
                $verify_link    = esc_url(add_query_arg(array('key' => $key_hash . '&verifyemail=' . $email), home_url('/', $protocol)));

                if (!empty($user_type) && $user_type === 'seller') {
                    $vendor_details                 = array();
                    $vendor_details['store_name']   = $display_name;

                    update_user_meta($user_identity, 'dokan_profile_settings', $vendor_details);

                    $blogname               = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                    $emailData              = array();
                    $emailData['name']      = $display_name;
                    $emailData['password']  = $random_password;
                    $emailData['email']     = $email;
                    $emailData['site']      = $blogname;
                    $emailData['verification_link'] = $verify_link;

                    if (class_exists('DoctreatRegisterNotify')) {
                        $email_helper = new DoctreatRegisterNotify();
                        $email_helper->send_seller_user_email($emailData);
                    }

                } else {
                    //Create Post
                    $user_post = array(
                        'post_title'        => wp_strip_all_tags($display_name),
                        'post_status'       => 'publish',
                        'post_author'       => $user_identity,
                        'post_type'         => $post_type,
                    );

                    $post_id = wp_insert_post($user_post);

                    if (!is_wp_error($post_id)) {

                        $profile_data = array();
                        $profile_data['am_first_name']  = $first_name;
                        $profile_data['am_last_name']   = $last_name;
                        update_post_meta($post_id, 'am_' . $post_type . '_data', $profile_data);

                        //Update user linked profile
                        update_user_meta($user_identity, '_linked_profile', $post_id);
                        update_post_meta($post_id, '_is_verified', 'no');
                        update_post_meta($post_id, '_linked_profile', $user_identity);
                        update_post_meta($post_id, 'is_featured', 0);

                        if (!empty($location)) {
                            $locations = get_term_by('slug', $location, 'locations');
                            $location_data = array();
                            if (!empty($locations)) {
                                $location_data[0] = $locations->term_id;
                                wp_set_post_terms($post_id, $locations->term_id, 'locations');
                            }
                        }

                        //update privacy settings
                        $settings = doctreat_get_account_settings($user_type);
                        if (!empty($settings)) {
                            foreach ($settings as $key => $value) {
                                $val = !empty($key) && $key === '_profile_blocked' ? 'off' : 'on';
                                update_post_meta($post_id, $key, $val);
                            }
                        }

                        $user_type = doctreat_get_user_type($user_identity);
                        if (!empty($user_type) && $user_type === 'doctors') {
                            if (function_exists('doctreat_get_package_type')) {
                                $trail_doctors_id = doctreat_get_package_type('package_type', 'trail_doctors');
                                if (!empty($trail_doctors_id)) {
                                    doctreat_update_package_data($trail_doctors_id, $user_identity, '', 1);
                                }
                            }
                        }

                        if (function_exists('doctreat_full_name')) {
                            $name = doctreat_full_name($post_id);
                        } else {
                            $name = $first_name;
                        }

                        //Send email to users
                        if (class_exists('Doctreat_Email_helper')) {
                            $blogname               = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                            $emailData              = array();
                            $emailData['name']      = $name;
                            $emailData['password']  = $random_password;
                            $emailData['email']     = $email;
                            $emailData['site']      = $blogname;
                            $emailData['verification_link'] = $verify_link;

                            //Send code
                            if (class_exists('DoctreatRegisterNotify')) {
                                $email_helper = new DoctreatRegisterNotify();
                                if (!empty($user_type) && $user_type === 'doctors') {
                                    $email_helper->send_doctor_email($emailData);
                                } else if (!empty($user_type) && $user_type === 'hospitals') {
                                    $email_helper->send_hospital_email($emailData);
                                } else if (!empty($user_type) && $user_type === 'regular_users') {
                                    $email_helper->send_regular_user_email($emailData);
                                    update_post_meta($post_id, '_is_verified', 'yes');
                                    update_user_meta($user_identity, '_is_verified', 'yes');
                                }
                            }

                        }

                    } else {
                        $json['type']       = 'error';
                        $json['message']    = esc_html__('Some error occurs, please try again later', 'doctreat_core');
                        return new WP_REST_Response($json, 203);
                    }
                }

                //Send admin email
                if (class_exists('DoctreatRegisterNotify')) {
                    $email_helper = new DoctreatRegisterNotify();
                    $email_helper->send_admin_email($emailData);
                }

                //verification
                if (empty($verify_user) || $verify_user == 'remove') {
                    update_post_meta($post_id, '_is_verified', 'yes');
                    update_user_meta($user_identity, '_is_verified', 'yes');
                    if (!empty($user_type) && $user_type == 'seller') {
                        update_user_meta($user_identity, 'dokan_enable_selling', 'yes');
                    }
                }

            }

            //User Login
            if (empty($verify_user) || $verify_user === 'yes') {
                $json_message = esc_html__("Your account has been created. Please check your email for the verification", 'doctreat_core');
            } else if (empty($verify_user) || $verify_user === 'remove') {
                $json_message = esc_html__("Thank you so much for the registration.", 'doctreat_core');
            } else {
                $json_message = esc_html__("Your account has been created. After the verification your will able to do anything on the site", 'doctreat_core');
            }

            $json['type']       = 'success';
            $json['ID']         = !empty($user_identity) ? intval($user_identity) : '';
            $json['message']    = $json_message;
            return new WP_REST_Response($json, 200);

        }

        /**
         * Account verification
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function account_verification($request)
        {
            $user_id        = !empty($request['user_id']) ? intval($request['user_id']) : 0;
            $json           = array();
            $current_user   = get_userdata($user_id);

            if (empty($current_user->user_email)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('User not found', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            //Send verification code
            if (class_exists('Doctreat_Email_helper')) {
                if (class_exists('DoctreatRegisterNotify')) {
                    $email_helper   = new DoctreatRegisterNotify();
                    $key_hash       = md5(uniqid(openssl_random_pseudo_bytes(32)));
                    update_user_meta($user_id, 'confirmation_key', $key_hash);
                    $protocol                       = is_ssl() ? 'https' : 'http';
                    $verify_link                    = esc_url(add_query_arg(array('key' => $key_hash . '&verifyemail=' . $current_user->user_email), home_url('/', $protocol)));
                    $blogname                       = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                    $emailData                      = array();
                    $emailData['name']              = doctreat_get_username($user_id);;
                    $emailData['email']             = $current_user->user_email;
                    $emailData['site']              = $blogname;
                    $emailData['verification_link'] = $verify_link;

                    $email_helper->send_verification($emailData);
                }
            }

            $json['type']       = 'success';
            $json['message']    = esc_html__('Verification email has been sent to your email address', 'doctreat_api');
            return new WP_REST_Response($json, 200);
        }

        /**
         * Get a collection of items
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_items($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            $items['data'] = array();
            return new WP_REST_Response($items, 200);
        }

        /**
         * Set Forgot Password
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_forgot_password($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            global $wpdb;
            $json           = array();
            $user_input     = !empty($request['email']) ? $request['email'] : '';

            if (empty($user_input)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Please add email address.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            } else if (!is_email($user_input)) {
                $json['type']       = "error";
                $json['message']    = esc_html__("Please add a valid email address.", 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            $user_data = get_user_by('email', $user_input);
            if (empty($user_data) || $user_data->caps['administrator'] == 1) {
                $json['type']       = "error";
                $json['message']    = esc_html__("Invalid E-mail address!", 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            $user_id            = $user_data->ID;
            $user_login         = $user_data->user_login;
            $user_email         = $user_data->user_email;
            $username           = doctreat_get_username($user_id);

            $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));

            if (empty($key)) {
                //generate reset key
                $key = wp_generate_password(20, false);
                $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
            }

            $protocol       = is_ssl() ? 'https' : 'http';
            $reset_link     = esc_url(add_query_arg(array('action' => 'reset_pwd', 'key' => $key, 'login' => $user_login), home_url('/', $protocol)));

            //Send email to user
            if (class_exists('Doctreat_Email_helper')) {
                if (class_exists('DoctreatGetPasswordNotify')) {
                    $email_helper       = new DoctreatGetPasswordNotify();
                    $emailData          = array();
                    $emailData['name']  = $username;
                    $emailData['email'] = $user_email;
                    $emailData['link']  = $reset_link;
                    $email_helper->send($emailData);
                }
            }

            $json['type']       = "success";
            $json['message']    = esc_html__("A link has been sent, please check your email.", 'doctreat_api');
            $json               = maybe_unserialize($json);
            return new WP_REST_Response($json, 203);

        }

        /**
         * Login user for application
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function user_login($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            global $theme_settings;
            $json           = array();
            $item           = array();
            $items          = array();
            $user_pmetadata = array();

            $fields = array(
                'username' => esc_html('User name is required', 'doctreat_api'),
                'password' => esc_html('Password is required', 'doctreat_api')
            );

            foreach ($fields as $key => $error_message) {
                if (empty($request[$key])) {
                    $json['type']       = 'error';
                    $json['message']    = $error_message;
                    return new WP_REST_Response($json, 203);
                }
            }

            $creds = array(
                'user_login'        => $request['username'],
                'user_password'     => $request['password'],
                'remember'          => true
            );

            $user = wp_signon($creds, false);

            if (is_wp_error($user)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Some error occur, please try again later.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            } else {

                unset($user->allcaps);
                unset($user->filter);

                $user_metadata  = array();
                $profile_data   = array();

                $profile_id                         = doctreat_get_linked_profile_id($user->data->ID);
                $enable_options                     = !empty($theme_settings['doctors_contactinfo']) ? 'enabled' : 'disable';
                $user_pmetadata['doctor_contacts']  = $enable_options;

                $listing_type = !empty($theme_settings['listing_type']) ? $theme_settings['listing_type'] : '';
                $user_pmetadata['listing_type'] = !empty($listing_type) ? $listing_type : 'paid';

                $booking_option                     = doctreat_theme_option('dashboad_booking_option');
                $user_pmetadata['booking_option']   = !empty($booking_option) ? 'enable' : 'disable';
                $user_type                          = apply_filters('doctreat_get_user_type', $user->data->ID);
                $oncall_option = 'disabled';
                if ('doctors' === $user_type) {
                    $booking_oncall = doctreat_get_booking_oncall_option();
                    if (!empty($booking_oncall)) {
                        $oncall_option              = 'enabled';
                    }
                    $user_pmetadata['user_type']    = 'doctor';

                } else if ('hospitals' == $user_type) {

                    $user_pmetadata['user_type']    = 'hospital';

                } else if ('regular_users' == $user_type) {

                    $user_pmetadata['user_type']    = 'regular_user';

                }

                $user_pmetadata['booking_oncall']   = $oncall_option;
                $user_pmetadata['profile_img']      = apply_filters('doctreat_doctor_avatar_fallback', doctreat_get_doctor_avatar(array('width' => 100, 'height' => 100), $profile_id), array('width' => 100, 'height' => 100));
                $user_meta = array(
                    'profile_id'    => $profile_id,
                    'id'            => $user->data->ID,
                    'user_login'    => $user->data->user_login,
                    'user_pass'     => $user->data->user_pass,
                    'user_email'    => $user->data->user_email
                );
                $user_meta_info = doctreat_get_post_meta($profile_id);

                $post_meta = array();

                $post_meta = array(
                    'am_name_base'          => 'am_name_base',
                    'am_sub_heading'        => 'am_sub_heading',
                    'am_first_name'         => 'am_first_name',
                    'am_last_name'          => 'am_last_name',
                    'am_short_description'  => 'am_short_description'
                );

                if (!empty($post_meta)) {
                    foreach ($post_meta as $key => $usermeta) {
                        $user_pmetadata[$key] = !empty($user_meta_info[$key]) ? $user_meta_info[$key] : '';
                    }
                }

                $user_pmetadata['full_name'] = get_the_title($profile_id);

                $shipping = '';
                $billing = '';
                if (class_exists('WC_Customer')) {
                    $customer   = new WC_Customer($user->data->ID);
                    $shipping   = $customer->get_shipping();
                    $billing    = $customer->get_billing();
                }
                $json['profile']['shipping']        = maybe_unserialize($shipping);
                $json['profile']['billing']         = maybe_unserialize($billing);
                $json['profile']['pmeta']           = maybe_unserialize($user_pmetadata);
                $json['profile']['umeta']           = maybe_unserialize($user_meta);
                $booking_option                     = doctreat_theme_option('system_access');
                $booking_option                     = !empty($booking_option) ? 'dc_locations' : 'hospitals_team';
                $json['profile']['location_type']   = $booking_option;

                $json['type']       = 'success';
                $json['message']    = esc_html__('You are logged in successfully', 'doctreat_api');

                $items = maybe_unserialize($json);
                return new WP_REST_Response($items, 200);
            }
        }

        public function get_access()
        {
            $json = array();
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            $json['type']   = "success";
            $json['rtl']    = is_rtl();

            return new WP_REST_Response($json, 200);
        }

        /**
         * Add Feedback
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function add_feedback($request)
        {
            global $wpdb;
            if (function_exists('doctreat_is_demo_api')) {
                doctreat_is_demo_api();
            } //if demo site then prevent

            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent


            $json       = array();
            $item       = array();
            $items      = array();
            $fields     = array(
                'feedback_recommend'        => esc_html('Recommendation is required.', 'doctreat_api'),
                'waiting_time'              => esc_html('Select the waiting time.', 'doctreat_api'),
                'feedback'                  => esc_html('Rating is required.', 'doctreat_api'),
                'feedback_description'      => esc_html('Description is required.', 'doctreat_api'),
                'doctor_id'                 => esc_html('Doctor ID is required.', 'doctreat_api'),
                'user_id'                   => esc_html('user ID is required.', 'doctreat_api'),
            );

            foreach ($fields as $key => $val) {
                if (empty($request[$key])) {
                    $json['type']       = 'error';
                    $json['message']    = $val;
                    return new WP_REST_Response($json, 203);
                }
            }

            $contents               = !empty($request['feedback_description']) ? sanitize_textarea_field($request['feedback_description']) : '';
            $recommend              = !empty($request['feedback_recommend']) ? sanitize_text_field($request['feedback_recommend']) : '';
            $waiting_time           = !empty($request['waiting_time']) ? sanitize_text_field($request['waiting_time']) : '';
            $doctor_profile_id      = !empty($request['doctor_id']) ? sanitize_text_field($request['doctor_id']) : '';
            $feedbackpublicly       = !empty($request['feedbackpublicly']) ? sanitize_text_field($request['feedbackpublicly']) : '';
            $reviews                = !empty($request['feedback']) ? $request['feedback'] : array();
            $user_identity          = !empty($request['user_id']) ? $request['user_id'] : '';
            $review_title           = get_the_title($doctor_profile_id);
            $doctor_id              = doctreat_get_linked_profile_id($doctor_profile_id, 'post');

            $user_reviews = array(
                'posts_per_page'    => 1,
                'post_type'         => 'reviews',
                'author'            => $doctor_id,
                'meta_key'          => '_user_id',
                'meta_value'        => $user_identity,
                'meta_compare'      => "=",
                'orderby'           => 'meta_value',
                'order'             => 'ASC',
            );

            $reviews_query = new WP_Query($user_reviews);
            $reviews_count = $reviews_query->post_count;

            if (isset($reviews_count) && $reviews_count > 0) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You have already submit a review.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            } else {
                $review_post = array(
                    'post_title'        => $review_title,
                    'post_status'       => 'publish',
                    'post_content'      => $contents,
                    'post_author'       => $doctor_id,
                    'post_type'         => 'reviews',
                    'post_date'         => current_time('Y-m-d H:i:s')
                );

                $post_id    = wp_insert_post($review_post);

                $rating_evaluation          = doctreat_doctor_ratings();
                $rating_evaluation_count    = !empty($rating_evaluation) ? doctreat_count_items($rating_evaluation) : 0;
                $review_extra_meta          = array();
                $rating                     = 0;
                $user_rating                = 0;

                if (!empty($rating_evaluation)) {
                    foreach ($rating_evaluation as $slug => $label) {
                        if (isset($reviews[$slug])) {
                            $review_extra_meta[$slug] = esc_html($reviews[$slug]);
                            update_post_meta($post_id, $slug, esc_html($reviews[$slug]));
                            $rating += (int)$reviews[$slug];
                        }
                    }
                }

                update_post_meta($post_id, '_user_id', $user_identity);
                update_post_meta($post_id, '_waiting_time', $waiting_time);
                update_post_meta($post_id, '_feedback_recommend', $recommend);
                update_post_meta($post_id, '_feedbackpublicly', $feedbackpublicly);

                if (!empty($rating)) {
                    $user_rating = $rating / $rating_evaluation_count;
                }

                $user_profile_id = doctreat_get_linked_profile_id($user_identity);
                $user_rating = number_format((float)$user_rating, 2, '.', '');
                $review_meta = array(
                    'user_rating'       => $user_rating,
                    'user_from'         => $user_profile_id,
                    'user_to'           => $doctor_profile_id,
                    'review_date'       => current_time('Y-m-d H:i:s'),
                );
                $review_meta = array_merge($review_meta, $review_extra_meta);

                //Update post meta
                foreach ($review_meta as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }

                $table_review = $wpdb->prefix . "posts";
                $table_meta = $wpdb->prefix . "postmeta";

                $db_rating_query = $wpdb->get_row("
					SELECT p.ID,
					SUM( pm2.meta_value ) AS db_rating,
					count( p.ID ) AS db_total
					FROM " . $table_review . " p 
					LEFT JOIN " . $table_meta . " pm1 ON (pm1.post_id = p.ID AND pm1.meta_key = 'user_to') 
					LEFT JOIN " . $table_meta . " pm2 ON (pm2.post_id = p.ID AND pm2.meta_key = 'user_rating')
					WHERE post_status = 'publish'
					AND pm1.meta_value = " . $doctor_profile_id . "
					AND p.post_type = 'reviews'
					", ARRAY_A);

                if (empty($db_rating_query)) {
                    $user_db_reviews['dc_average_rating'] = 0;
                    $user_db_reviews['dc_total_rating'] = 0;
                    $user_db_reviews['dc_total_percentage'] = 0;
                    $user_db_reviews['wt_rating_count'] = 0;
                } else {

                    $rating = !empty($db_rating_query['db_rating']) ? $db_rating_query['db_rating'] / $db_rating_query['db_total'] : 0;
                    $user_rating = number_format((float)$rating, 2, '.', '');

                    $user_db_reviews['dc_average_rating'] = $user_rating;
                    $user_db_reviews['dc_total_rating'] = !empty($db_rating_query['db_total']) ? $db_rating_query['db_total'] : '';
                    $user_db_reviews['dc_total_percentage'] = $user_rating * 20;
                    $user_db_reviews['dc_rating_count'] = !empty($db_rating_query['db_rating']) ? $db_rating_query['db_rating'] : '';
                }

                update_post_meta($doctor_profile_id, 'review_data', $user_db_reviews);
                update_post_meta($doctor_profile_id, 'rating_filter', $user_rating);

                $total_rating       = get_post_meta($doctor_profile_id, '_total_voting', true);
                $total_rating       = !empty($total_rating) ? $total_rating + 1 : 0;
                $total_recommend    = get_post_meta($doctor_profile_id, '_recommend', true);
                $total_recommend    = !empty($total_recommend) ? $total_recommend : 0;
                $total_recommend    = !empty($recommend) && $recommend === 'yes' ? $total_recommend + 1 : $total_recommend;

                update_post_meta($doctor_profile_id, '_recommend', $total_recommend);
                update_post_meta($doctor_profile_id, '_total_voting', $total_rating);

                $json['type']       = 'success';
                $json['message']    = esc_html__('Your feedback is successfully submitted.', 'doctreat_api');
                return new WP_REST_Response($json, 200);
            }
        }

        /**
         * Get Feedback option
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_feedback_options($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            global $theme_settings;
            $json       = array();
            $user_id    = !empty($request['user_id']) ? $request['user_id'] : '';
            $id         = !empty($request['doctor_id']) ? $request['doctor_id'] : '';
            $user_type  = apply_filters('doctreat_get_user_type', $user_id);
            $metadata   = array();

            if (empty($user_id)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('Login to add feedback.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if (empty($id)) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('no kidds.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if (!empty($user_type) && $user_type != 'regular_users') {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You are not allowed to add feedback.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
            $doctor_id = doctreat_get_linked_profile_id($id, 'post');

            $user_reviews = array(
                'posts_per_page'        => 1,
                'post_type'             => 'reviews',
                'author'                => $doctor_id,
                'meta_key'              => '_user_id',
                'meta_value'            => $user_id,
                'meta_compare'          => "=",
                'orderby'               => 'meta_value',
                'order'                 => 'ASC',
            );

            $reviews_query = new WP_Query($user_reviews);
            $reviews_count = $reviews_query->post_count;

            if (isset($reviews_count) && $reviews_count > 0) {
                $json['type']       = 'error';
                $json['message']    = esc_html__('You have already submit a review.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if ($user_type === 'regular_users' && !empty($id)) {
                $feedback_option        = !empty($theme_settings['feedback_option']) ? $theme_settings['feedback_option'] : '';
                $rating_headings        = doctreat_doctor_ratings();
                $waiting_time_headings  = doctreat_get_waiting_time();

                $rating_array = array();
                if (!empty($rating_headings)) {
                    $ratings = array();
                    foreach ($rating_headings as $key => $rating) {
                        $ratings['key']     = $key;
                        $ratings['title']   = $rating;
                        $rating_array[]     = $ratings;
                    }
                }

                $waiting_time_array = array();
                if (!empty($waiting_time_headings)) {
                    $waiting_times = array();
                    foreach ($waiting_time_headings as $key => $waiting_time) {
                        $waiting_times['key']   = $key;
                        $waiting_times['title'] = $waiting_time;
                        $waiting_time_array[]   = $waiting_times;
                    }
                }
                if (empty($feedback_option)) {
                    $json['type']       = 'success';
                    $json['rating']     = maybe_unserialize($rating_array);
                    $json['times']      = maybe_unserialize($waiting_time_array);
                    $json['message']    = esc_html__('Please add your feed back.', 'doctreat_api');
                    return new WP_REST_Response($json, 200);
                } else {

                    $metadata['_doctor_id'] = $id;
                    $bookings = doctreat_get_total_posts_by_multiple_meta('booking', 'publish', $metadata, $user_id);

                    if (!empty($bookings) && $bookings > 0) {
                        $json['rating']     = maybe_unserialize($rating_array);
                        $json['times']      = maybe_unserialize($waiting_time_array);
                        $json['type']       = 'success';
                        $json['message']    = esc_html__('Please add your feed back.', 'doctreat_api');

                        return new WP_REST_Response($json, 200);
                    } else {
                        $json['type']       = 'error';
                        $json['message']    = esc_html__('You need to complete atleast 1 appointment to add feedback.', 'doctreat_api');
                        return new WP_REST_Response($json, 203);
                    }
                }
            } else {
                $json['type']       = 'error';
                $json['message']    = esc_html__('no kidds.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }

        /**
         * Get user packages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function get_packages($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            $json = array();
            $user_type = !empty($request['user_type']) ? $request['user_type'] : '';
            if (!empty($user_type)) {
                $pakeges_features   = doctreat_get_pakages_features();
                $currency_symbol    = doctreat_get_current_currency();
                $args = array(
                    'post_type'             => 'product',
                    'posts_per_page'        => -1,
                    'post_status'           => 'publish',
                    'ignore_sticky_posts'   => 1
                );
                $meta_query_args[] = array(
                    'key'           => 'package_type',
                    'value'         => $user_type,
                    'compare'       => '=',
                );

                $query_relation         = array('relation' => 'AND',);
                $meta_query_args        = array_merge($query_relation, $meta_query_args);
                $args['meta_query']     = $meta_query_args;
                $loop                   = new WP_Query($args);
                $array_packages         = array();
                while ($loop->have_posts()) : $loop->the_post();
                    global $product;
                    $product_array              = array();
                    $post_id                    = intval($product->get_id());
                    $duration_type              = get_post_meta($post_id, 'dc_duration', true);
                    $duration_title             = doctreat_get_duration_types($duration_type, 'title');
                    $product_array['ID']        = $post_id;
                    $product_array['title']     = get_the_title($post_id);
                    $product_array['price']     = $product->get_price();
                    $product_array['duration']  = !empty($duration_title) ? $duration_title : '';
                    $product_array['symbol']    = !empty($currency_symbol['symbol']) ? $currency_symbol['symbol'] : '';

                    if (!empty($pakeges_features)) {
                        $featured_array = array();
                        foreach ($pakeges_features as $key => $values) {
                            if ($values['user_type'] === 'doctors' || $values['user_type'] === 'common') {
                                $featurs = array();
                                $item = get_post_meta($post_id, $key, true);
                                if (isset($key) && $key === 'dc_duration') {
                                    $item = doctreat_get_duration_types($item, 'value');
                                } elseif (isset($key) && $key === 'dc_featured_duration') {
                                    $item = $item . ' (' . esc_html__('days', 'doctreat_api') . ')';
                                }
                                $featurs['title'] = $values['title'];
                                $featurs['value'] = !empty($item) ? $item : '';
                                $featured_array[] = $featurs;
                            }
                        }
                        $product_array['features'] = $featured_array;
                    }

                    $array_packages[] = $product_array;
                endwhile;
                wp_reset_postdata();
                $json['type']       = "success";
                $json['pakcages']   = maybe_unserialize($array_packages);
                return new WP_REST_Response($json, 200);
            } else {
                $json['type']       = "error";
                $json['message']    = esc_html__('User ID required', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }

        /**
         * Create temp chekcout data
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function create_checkout_page($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            global $wpdb;
            $json       = array();
            $item       = array();
            $items      = array();
            $params     = $request->get_params();
            if (!empty($params['payment_data'])) {

                $insert_data = "insert into `" . MOBILE_APP_TEMP_CHECKOUT . "` set `temp_data`='" . stripslashes($params['payment_data']) . "'";
                $wpdb->query($insert_data);

                if (isset($wpdb->insert_id)) {
                    $data_id = $wpdb->insert_id;
                } else {
                    $data_id = $wpdb->print_error();
                }

                $json['type'] = "success";
                $json['message'] = esc_html__("You order has been placed, Please pay to make it complete", "doctreat_api");

                $pages = query_posts(array(
                    'post_type' => 'page',
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'mobile-checkout.php'
                ));

                $url = null;
                if (!empty($pages[0])) {
                    $url = get_page_link($pages[0]->ID) . '?order_id=' . $data_id . '&platform=mobile';
                }

                $json['url'] = esc_url($url);
                return new WP_REST_Response($json, 200);
            } else {
                $json['type'] = "error";
                $json['message'] = esc_html__("Invalid Parem Data", 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

        }

        /**
         * Logout user from the application
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */

        public function do_logout($request)
        {
            if (function_exists('doctreat_api_auth')) {
                doctreat_api_auth($request);
            } //if demo site then prevent

            $json = array();
            if (!empty($request['user_id'])) {
                $user_id = $request['user_id'];
                $sessions = WP_Session_Tokens::get_instance($user_id);

                $sessions->destroy_all();

                $json['type'] = "success";
                $json['message'] = esc_html__('You are logged out successfully', 'doctreat_api');
                return new WP_REST_Response($json, 200);
            } else {
                $json['type'] = "error";
                $json['message'] = esc_html__('User ID required', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
        }

        /**
         * Get booking options
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */

        public function get_theme_settings()
        {
            global $theme_settings;
            $json = array();
            $enable_options = !empty($theme_settings['doctors_contactinfo']) ? $theme_settings['doctors_contactinfo'] : '';
            $doctor_booking_option = !empty($theme_settings['booking_system_contact']) ? $theme_settings['booking_system_contact'] : '';
            $doctor_system_access = !empty($theme_settings['system_access']) ? $theme_settings['system_access'] : '';
            $listing_type = !empty($theme_settings['listing_type']) ? $theme_settings['listing_type'] : '';

            $json['doctor_contacts'] = !empty($enable_options) ? 'enable' : 'disable';
            $json['listing_type'] = !empty($listing_type) ? $listing_type : 'paid';
            $json['payment_type'] = !empty($theme_settings['payment_type']) ? $theme_settings['payment_type'] : 'online';
            $json['precription_details'] = !empty($theme_settings['precription_details']) ? $theme_settings['precription_details'] : 'hospital';
            $json['show_earning'] = !empty($theme_settings['show_earning']) ? $theme_settings['show_earning'] : 'hide';
            $json['enable_checkout_page'] = !empty($theme_settings['enable_checkout_page']) ? 'yes' : 'no';
            $json['verify_user'] = !empty($theme_settings['verify_user']) ? $theme_settings['verify_user'] : 'no';
            $json['booking_verification'] = !empty($theme_settings['booking_verification']) ? 'yes' : 'no';
            $json['payout_methods'] = !empty($theme_settings['payout_setting']) ? $theme_settings['payout_setting'] : array();
            $json['doctor_location'] = !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : 'both';
            $json['doctor_booking_option'] = !empty($doctor_booking_option) && $doctor_booking_option === 'doctor' ? 'enable' : 'disbale';
            $json['booking_contact_numbers'] = !empty($theme_settings['booking_contact_numbers']) ? $theme_settings['booking_contact_numbers'] : array();
            $json['doctor_system_access'] = !empty($doctor_system_access) ? 'enable' : 'disbale';
            $json['user_type_registration'] = !empty($theme_settings['user_type_registration']) ? $theme_settings['user_type_registration'] : array();
            $json['allow_consultation_zero'] = !empty($theme_settings['allow_consultation_zero']) ? $theme_settings['allow_consultation_zero'] : 'no';
            $json['allow_booking_zero'] = !empty($theme_settings['allow_booking_zero']) ? $theme_settings['allow_booking_zero'] : 'no';
            $json['dashboad_booking_option'] = !empty($theme_settings['dashboad_booking_option']) ? $theme_settings['dashboad_booking_option'] : '';
            $json['feedback_option'] = !empty($theme_settings['feedback_option']) ? $theme_settings['feedback_option'] : 'no';
            $json['multiple_locations'] = !empty($theme_settings['multiple_locations']) ? $theme_settings['multiple_locations'] : 'no';
            $json['remove_hos_invite'] = !empty($theme_settings['remove_hos_invite']) ? $theme_settings['remove_hos_invite'] : 'no';
            $json['base_name_disable'] = !empty($theme_settings['base_name_disable']) && !empty($theme_settings['base_name_disable']) ? 'yes' : 'no';
            $json['name_base_doctors'] = !empty($theme_settings['name_base_doctors']) ? $theme_settings['name_base_doctors'] : array();
            $json['name_base_users'] = !empty($theme_settings['name_base_users']) ? $theme_settings['name_base_users'] : array();
            $json['calendar_locale'] = !empty($theme_settings['calendar_locale']) ? $theme_settings['calendar_locale'] : 'en';
            $json['calendar_format'] = !empty($theme_settings['calendar_format']) ? $theme_settings['calendar_format'] : 'Y-m-d';
            $json['feedback_questions'] = !empty($theme_settings['feedback_questions']) ? $theme_settings['feedback_questions'] : array();
            $json['enable_gallery'] = !empty($theme_settings['enable_gallery']) && !empty($theme_settings['enable_gallery']) ? 'yes' : 'no';
            $json['hide_chat_buble'] = !empty($theme_settings['hide_chat_buble']) ? $theme_settings['hide_chat_buble'] : 'no';
            $json['chat'] = !empty($theme_settings['chat']) ? $theme_settings['chat'] : 'inbox';
            $json['default_doctor_avatar'] = !empty($theme_settings['default_doctor_avatar']['url']) ? $theme_settings['default_doctor_avatar']['url'] : '';
            $json['default_others_users'] = !empty($theme_settings['default_others_users']['url']) ? $theme_settings['default_others_users']['url'] : '';
            $json['new_messages'] = !empty($theme_settings['new_messages']['url']) ? $theme_settings['new_messages']['url'] : '';
            $json['total_appointments'] = !empty($theme_settings['total_appointments']['url']) ? $theme_settings['total_appointments']['url'] : '';
            $json['saved_items'] = !empty($theme_settings['saved_items']['url']) ? $theme_settings['saved_items']['url'] : '';
            $json['available_balance'] = !empty($theme_settings['available_balance']['url']) ? $theme_settings['available_balance']['url'] : '';
            $json['package_expiry'] = !empty($theme_settings['package_expiry']['url']) ? $theme_settings['package_expiry']['url'] : '';
            $json['service_spec'] = !empty($theme_settings['service_spec']['url']) ? $theme_settings['service_spec']['url'] : '';
            $json['invoice_img'] = !empty($theme_settings['invoice_img']['url']) ? $theme_settings['invoice_img']['url'] : '';
            $json['published_articles_img'] = !empty($theme_settings['published_articles_img']['url']) ? $theme_settings['published_articles_img']['url'] : '';
            $json['dashboard_payouts'] = !empty($theme_settings['dashboard_payouts']['url']) ? $theme_settings['dashboard_payouts']['url'] : '';
            $json['article_add_url'] = !empty($theme_settings['article_add_url']['url']) ? $theme_settings['article_add_url']['url'] : '';
            $json['manage_team_img'] = !empty($theme_settings['manage_team_img']['url']) ? $theme_settings['manage_team_img']['url'] : '';
            $json['pdf_logo'] = !empty($theme_settings['pdf_logo']['url']) ? $theme_settings['pdf_logo']['url'] : '';
            $json['dir_map_marker'] = !empty($theme_settings['dir_map_marker']['url']) ? $theme_settings['dir_map_marker']['url'] : '';
            $json['registration_image'] = !empty($theme_settings['step_image']['thumbnail']) ? $theme_settings['step_image']['thumbnail'] : '';
            $json['dir_latitude'] = !empty($theme_settings['dir_latitude']) ? $theme_settings['dir_latitude'] : '51.5001524';
            $json['dir_longitude'] = !empty($theme_settings['dir_longitude']) ? $theme_settings['dir_longitude'] : '-0.1262362';
            $json['dir_zoom'] = !empty($theme_settings['dir_zoom']) ? $theme_settings['dir_zoom'] : 11;
            $json['step_title'] = !empty($theme_settings['step_title']) ? $theme_settings['step_title'] : '';
            $json['step_description'] = !empty($theme_settings['step_description']) ? $theme_settings['step_description'] : '';
            $json['social_links'] = !empty($theme_settings['social_links']) ? $theme_settings['social_links'] : '';


            $social_settings = function_exists('doctreat_get_social_media_icons_list') ? doctreat_get_social_media_icons_list('yes') : array();
            if (!empty($social_settings)) {
                foreach ($social_settings as $key => $val) {
                    $json[$key] = !empty($theme_settings[$key]) ? 'yes' : 'no';
                }
            }

            return new WP_REST_Response($json, 200);
        }

        /**
         * Get booking options
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */

        public function get_booking_options($request)
        {
            global $theme_settings;
            $json = array();
            $item = array();

            $user_id = !empty($request['user_id']) ? intval($request['user_id']) : '';
            $profile_id = doctreat_get_linked_profile_id($user_id);
            $booking_option = !empty($theme_settings['booking_system_contact']) ? $theme_settings['booking_system_contact'] : '';

            if (empty($booking_option) || $booking_option === 'admin') {
                $contact_numbers = doctreat_get_post_meta($profile_id, 'am_booking_contact');
                $booking_detail = doctreat_get_post_meta($profile_id, 'am_booking_detail');

            } else {
                $contact_numbers = !empty($theme_settings['booking_contact_numbers']) ? $theme_settings['booking_contact_numbers'] : array();
                $booking_detail = !empty($theme_settings['booking_contact_detail']) ? $theme_settings['booking_contact_detail'] : '';
            }

            $contact_array = array();
            if (!empty($contact_numbers)) {
                foreach ($contact_numbers as $contact_number) {
                    if (!empty($contact_number)) {
                        $contact_array[]['number'] = $contact_number;
                    }
                }
            }
            $bookig_setting['details'] = !empty($booking_detail) ? $booking_detail : '';
            $bookig_setting['phone_numbers'] = $contact_array;

            $item['bookig_setting'] = $bookig_setting;
            $items[] = maybe_unserialize($item);
            return new WP_REST_Response($items, 200);
        }
    }
}

add_action('rest_api_init',
    function () {
        $controller = new DoctreatApp_User_Route;
        $controller->register_routes();
    });
