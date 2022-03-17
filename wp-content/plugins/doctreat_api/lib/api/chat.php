<?php
/**
 * APP API to manage chat
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if (!class_exists('DoctreatApp_Chat_Route')) {

    class DoctreatApp_Chat_Route extends WP_REST_Controller{

        /**
         * Register the routes for the chat.
         */
        public function register_routes() {
            $version 	= '1';
            $namespace 	= 'api/v' . $version;
            $base 		= 'chat';
			
			//user login
            register_rest_route($namespace, '/' . $base . '/send_messge',
                array(                 
                    array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'send_messge'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
            
            //Send user message
            register_rest_route($namespace, '/' . $base . '/sendUserMessage',
                array(                 
                    array(
                        'methods' 	=> WP_REST_Server::CREATABLE,
                        'callback' 	=> array(&$this, 'sendUserMessage'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//List users
            register_rest_route($namespace, '/' . $base . '/list_users',
                array(
                  array(
                        'methods' 	=> WP_REST_Server::READABLE,
                        'callback' 	=> array(&$this, 'list_users'),
                        'args' 		=> array(),
						'permission_callback' => '__return_true',
                    ),
                )
            );
			
			//list messages
            register_rest_route($namespace, '/' . $base . '/list_user_messages',
            array(
				  array(
						'methods' 	=> WP_REST_Server::READABLE,
						'callback' 	=> array(&$this, 'list_user_messages'),
						'args' 		=> array(),
						'permission_callback' => '__return_true',
					),
				)
			);
			
        }

         /**
         * List single user messages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function list_user_messages($request){
            $json = array();
			
			$senderID 		= !empty( $request['current_id'] ) ? intval( $request['current_id'] ) : '';
            $receiverID 	= !empty( $request['reciver_id'] ) ? intval( $request['reciver_id'] ) : '';
            $lastMsgId 		= !empty( $request['msg_id'] ) ? intval( $request['msg_id'] ) : '';
            $thread_page 	= !empty( $request['page_number'] ) ? intval( $request['page_number'] ) : 0;

            if(!empty($receiverID)){
                 //Create Chat Sidebar Data
                 $chat_sidebar = array();
                 $chat_sidebar['avatar'] 		= ChatSystem::getUserInfoData('avatar', $senderID, array('width' => 100, 'height' => 100));
                 $chat_sidebar['username'] 		= ChatSystem::getUserInfoData('username', $senderID, array());
                 $chat_sidebar['user_register']  = ChatSystem::getUserInfoData('user_register', $senderID, array());
            }
            
            if ( $receiverID != $senderID ) {
                $usersThreadData = ChatSystem::getUsersThreadListData($senderID, $receiverID, 'fetch_thread_last_items', array(), '',$thread_page);
                //Update Chat Status in DB
                ChatSystem::getUsersThreadListData($senderID, $receiverID, 'set_thread_status', array(), '');
				
                //Prepare Chat Nodes
                $chat_nodes     = array();
                if (!empty($usersThreadData)) {
                    foreach ($usersThreadData as $key => $val) {

                        $chat_nodes[$key]['chat_is_sender'] = 'no';
                        if ($val['sender_id'] == $senderID) {
                            $chat_nodes[$key]['chat_is_sender'] = 'yes';
                        }

                        $date = !empty($val['time_gmt']) ?  date(get_option('date_format'), strtotime($val['time_gmt'])) : '';
                        $chat_nodes[$key]['chat_avatar'] 			= ChatSystem::getUserInfoData('avatar', $val['sender_id'], array('width' => 100, 'height' => 100));
                        $chat_nodes[$key]['chat_username'] 			= ChatSystem::getUserInfoData('username', $val['sender_id'], array());
                        $chat_nodes[$key]['chat_message'] 			= $val['chat_message'];
                        $chat_nodes[$key]['chat_date'] 				= $date;
                        $chat_nodes[$key]['chat_id'] 				= intval($val['id']);
                        $chat_nodes[$key]['chat_current_user_id'] 	= intval($senderID);
                    }
                }
				
                $json['chat_nodes'] 			= $chat_nodes;
                $json['chat_receiver_id'] 		= intval($receiverID);
                $json['chat_sender_id'] 		= intval($senderID);
                $json['chat_sidebar'] 			= $chat_sidebar;
                $json					        = maybe_unserialize($json);
                return new WP_REST_Response($json, 200);
            }
        }

        /**
         * List users messages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function sendUserMessage($request){

            $json = array();
			
            $receiver_id	= !empty( $request['receiver_id'] ) ? intval($request['receiver_id']) : '';
            $sender_id	    = !empty( $request['sender_id'] ) ? intval($request['sender_id']) : '';
            $status			= !empty( $request['status'] ) && esc_attr( $request['status'] ) === 'read' ? 0 : 1;
            $msg_type		= !empty( $request['msg_type'] ) && esc_attr( $request['msg_type'] ) === 'modal' ? 'modal' : 'normals';
            $message		= !empty( $request['message'] ) ? esc_textarea($request['message']) : '';

            if (empty($receiver_id)) {
                $json['type']           = 'error';
                $json['message']        = esc_html__('No kiddies please.', 'doctreat_api');
                $json					= maybe_unserialize($json);
                return new WP_REST_Response($json, 203);
            }

            if (empty($sender_id) ) {
                $json['type']   = 'error';
                $json['message'] = esc_html__('Sender ID is required.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if (empty($message)) {
                $json['type']           = 'error';
                $json['message']        = esc_html__('Message field is required.', 'doctreat_api');
                $json					= maybe_unserialize($json);
                return new WP_REST_Response($json, 203);
            }

            $current_time  = current_time('mysql');
            $gmt_time      = get_gmt_from_date($current_time);
			
            $insert_data = array(
                'sender_id' 		=> $sender_id,
                'receiver_id' 		=> $receiver_id,
                'chat_message' 		=> $message,
                'status' 			=> $status,
                'timestamp' 		=> time(),
                'time_gmt' 			=> $gmt_time,
            );

            $msg_id = ChatSystem::getUsersThreadListData($sender_id, $receiver_id, 'insert_msg', $insert_data, '');
            $json['msg_id']         = $msg_id;
            $json					= maybe_unserialize($json);
            return new WP_REST_Response($json, 200);
            
        }

        /**
         * List users messages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Response
         */
        public function list_users($request){

            $user_id	= !empty( $request['user_id'] ) ? intval($request['user_id']) : '';

            if(!empty( $user_id )) {
                $usersdata = ChatSystem::getUsersThreadListData($user_id, '', 'list', array(), '');
                $chat_messages  = array();
                $json           = array();
                if(!empty($usersdata)) {
                    foreach ($usersdata as $key => $users ) {
                        $chat_messages[$key]['msg_id']          = !empty($users['id']) ? intval($users['id']) : 0;
                        $chat_messages[$key]['chat_message']    = !empty($users['chat_message']) ? $users['chat_message'] : '';
                        $chat_messages[$key]['message_status']  = !empty($users['status']) ? $users['status'] : '';

                        if ($user_id === intval($users['sender_id'])) {
                            $chat_user_id = intval($users['receiver_id']);
                        } else {
                            $chat_user_id = intval($users['sender_id']);
                        }

                        $chat_messages[$key]['receiver_id'] = $chat_user_id;
                        
                        $userAvatar = ChatSystem::getUserInfoData('avatar', $chat_user_id, array('width' => 100, 'height' => 100));
                        $userName 	= ChatSystem::getUserInfoData('username', $chat_user_id, array());
                        $userUrl 	= ChatSystem::getUserInfoData('url', $chat_user_id, array());
                        $count 		= ChatSystem::getUsersThreadListData($chat_user_id,$user_id,'count_unread_msgs_by_user');
                        $unread		= !empty( $count ) ? $count : 0;
                        $chat_messages[$key]['image_url']       = !empty($userAvatar) ? esc_url($userAvatar) : '';
                        $chat_messages[$key]['user_name']       = !empty($userName) ? esc_attr($userName) : '';
                        $chat_messages[$key]['unread_count']    = !empty($unread) ? intval($unread) : 0;
                    }
                }
				
                $json					= maybe_unserialize($chat_messages);
				return new WP_REST_Response($json, 200);
            } else {
                $json['type'] 			= "error";
                $json['message']		= esc_html__('User ID is required field.','doctreat_api');	
                $json					= maybe_unserialize($json);
                return new WP_REST_Response($json, 203);
            }

        }
				
		/**
         * Send messages
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
         */
        public function send_messge($request) {
			
			$json = array();
			
			$receiver_id	= !empty( $request['receiver_id'] ) ? intval($request['receiver_id']) : '';
			$senderId		= !empty( $request['sender_id'] ) ? intval($request['sender_id']) : '';
            $status			= !empty( $request['status'] ) && esc_attr( $request['status'] ) === 'read' ? 0 : 1;
			$message		= !empty( $request['message'] ) ? esc_textarea($request['message']) : '';
			
            if (empty($receiver_id)) {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('User ID is required.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
			
			if (empty($senderId)) {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Sender ID is required.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }

            if (empty($message)) {
                $json['type'] 		= 'error';
                $json['message'] 	= esc_html__('Message field is required.', 'doctreat_api');
                return new WP_REST_Response($json, 203);
            }
			
            $receiverId = intval($receiver_id);

            //Prepare Insert Message Data Array
            $current_time  = current_time('mysql');
            $gmt_time      = get_gmt_from_date($current_time);
			
			
            $insert_data = array(
                'sender_id' 		=> $senderId,
                'receiver_id' 		=> $receiverId,
                'chat_message' 		=> $message,
                'status' 			=> $status,
                'timestamp' 		=> time(),
                'time_gmt' 			=> $gmt_time,
            );

            $msg_id = ChatSystem::getUsersThreadListData($senderId, $receiverId, 'insert_msg', $insert_data, '');
			
			if( !empty( $msg_id ) ) {

				$json['type'] 		= 'success';
				$json['message'] 	= esc_html__('Your offer has been submitted', 'doctreat_api');                
				return new WP_REST_Response($json, 200);
			}else {
				$json['type'] = 'error';
				$json['message'] = esc_html__('Some error occurs, please try again later', 'doctreat_api');                
				return new WP_REST_Response($json, 203);
			}               
        }
    }
}

add_action('rest_api_init',
        function () {
			$controller = new DoctreatApp_Chat_Route;
			$controller->register_routes();
});
