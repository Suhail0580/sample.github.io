<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_Reviews')) {

    class Doctreat_Reviews {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_directory_type'));
			add_filter('manage_reviews_posts_columns', array(&$this, 'reviews_columns_add'));
			add_action('manage_reviews_posts_custom_column', array(&$this, 'reviews_columns'),10, 2);	
			add_action('add_meta_boxes', array(&$this, 'reviews_add_meta_box'), 10, 1);
			add_action('save_post', array(&$this, 'reviews_save_meta_box'), 10);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_directory_type() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type Category
         * @return post type
         */
        public function prepare_post_type() {
            $labels = array(
                'name' 				=> esc_html__('Reviews', 'doctreat_core'),
                'all_items' 		=> esc_html__('Reviews', 'doctreat_core'),
                'singular_name' 	=> esc_html__('Reviews', 'doctreat_core'),
                'add_new' 			=> esc_html__('Add Review', 'doctreat_core'),
                'add_new_item' 		=> esc_html__('Add New Review', 'doctreat_core'),
                'edit' 				=> esc_html__('Edit', 'doctreat_core'),
                'edit_item' 		=> esc_html__('Edit Review', 'doctreat_core'),
                'new_item' 			=> esc_html__('New Review', 'doctreat_core'),
                'view' 				=> esc_html__('View Review', 'doctreat_core'),
                'view_item' 		=> esc_html__('View Review', 'doctreat_core'),
                'search_items' 		=> esc_html__('Search Review', 'doctreat_core'),
                'not_found' 		=> esc_html__('No Review found', 'doctreat_core'),
                'not_found_in_trash' 	=> esc_html__('No Review found in trash', 'doctreat_core'),
                'parent' 				=> esc_html__('Parent Reviews', 'doctreat_core'),
            );
            $args = array(
                'labels' 			=> $labels,
                'description' 		=> esc_html__('This is where you can add new Reviews ', 'doctreat_core'),
                'public' 			=> true,
                'supports' 			=> array('title', 'editor'),
                'show_ui' 			=> true,
                'capability_type' 	=> 'post',
                'map_meta_cap' 		=> true,
                'publicly_queryable' 	=> false,
                'exclude_from_search' 	=> true,
                'hierarchical' 			=> false,
				'show_in_menu' 			=> 'edit.php?post_type=doctors',
                'menu_position' 		=> 10,
                'rewrite' 				=> array('slug' => 'reviews', 'with_front' => true),
                'query_var' 			=> false,
                'has_archive' 			=> false,
				'capabilities' 			=> array('create_posts' => false)
            );
            register_post_type('reviews', $args);
        }
		
		/**
         * @Init Meta Boxes
         * @return {post}
         */
        public function reviews_add_meta_box($post_type) {
            if ($post_type == 'reviews') {
                add_meta_box(
                        'reviews_info', esc_html__('Review Info', 'doctreat_core'), array(&$this, 'reviews_meta_box_reviewinfo'), 'reviews', 'side', 'high'
                );
            }
        }
		
		/**
         * @Init Review info
         * @return {post}
         */
        public function reviews_meta_box_reviewinfo() {
            global $post;
			$user_from_id 		= get_post_meta( $post->ID, 'user_from', true );
			$user_to_id 		= get_post_meta( $post->ID, 'user_to', true );
			$rating 			= get_post_meta( $post->ID, 'user_rating', true );
			
			$user_from 			= doctreat_get_username( '' , $user_from_id );
			$user_to 			= doctreat_get_username( '' , $user_to_id );
            
            ?>
            <ul class="review-info">
                <li>
                    <span class="push-left">
                    	<strong>
                    		<?php esc_html_e('Rating:', 'doctreat_core'); ?>
                    	</strong>
                    </span>
                    <span class="push-right">
                    	<?php echo esc_html($rating); ?>
                    </span>
                </li>
                <?php if (!empty( $user_from )) { ?>
                    <li>
                        <span class="push-left">
                        	<strong><?php esc_html_e('Review By', 'doctreat_core'); ?>:</strong>
                        </span>
                        <span class="push-right">
                        	<a href="<?php echo esc_url( get_the_permalink($user_from_id)); ?>" target="_blank" title="<?php esc_html_e('Click for user details', 'doctreat_core'); ?>">
                        		<?php echo esc_html($user_from);?>
                        </span>
                    </li>
                <?php } ?>
                <?php if (!empty( $user_to )) { ?>
                    <li>
                        <span class="push-left">
                        	<strong>
                        		<?php esc_html_e('Review To', 'doctreat_core'); ?>
                        	</strong>
                        </span>
                        <span class="push-right">
                        	<a href="<?php echo esc_url( get_the_permalink( $user_to_id )); ?>" target="_blank" title="<?php esc_html__('Click for user details', 'doctreat_core'); ?>">
                        		<?php echo esc_html( $user_to ); ?>
                        	</a>
                        </span>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
		
		/**
         * @Init Save Meta Boxes
         * @return {post}
         */
        public function reviews_save_meta_box() {
            global $post;
           
        }
		/**
		 * @Prepare Columns
		 * @return {post}
		 */
		public function reviews_columns_add($columns) {
			unset($columns['author']);
			$columns['user_rating'] 		= esc_html__('Review','doctreat_core');
		//	$columns['project'] 			= esc_html__('Project','doctreat_core');
			$columns['user_from'] 			= esc_html__('Review by','doctreat_core');
			$columns['user_to'] 			= esc_html__('Review to','doctreat_core');
		 
  			return $columns;
		}
		
		/**
		 * @Get Columns
		 * @return {}
		 */
		public function reviews_columns($name) {
            global $post;
			
			$user_from 		= get_post_meta( $post->ID, 'user_from', true );
			$user_to 		= get_post_meta( $post->ID, 'user_to', true );
			$rating 		= get_post_meta( $post->ID, 'user_rating', true );

			$user_from			= !empty( $user_from ) ? $user_from : '';
			$user_to			= !empty( $user_to ) ? $user_to : '';
			$rating				= !empty( $rating ) ? $rating : '';
			
			$user_from_title 		= doctreat_get_username( '' , $user_from );
			$user_to_title 			= doctreat_get_username( '' , $user_to );

			$link_from   			= '<a href="'.get_edit_post_link($user_from).'">'.$user_from_title.'</a>';
			$link_to   				= '<a href="'.get_edit_post_link($user_to).'">'.$user_to_title.'</a>';

            switch ($name) {
                case 'user_from':
                   if (!empty( $link_from) ) {
                        echo force_balance_tags( $link_from );
                    }
                    break;
                case 'user_to':
                    if (!empty( $link_to ) ) {
                        echo force_balance_tags( $link_to );
                    }
                    break;
                case 'user_rating':
                    echo do_shortcode( $rating );
                    break;
            }
        }

    }

    new Doctreat_Reviews();
}


