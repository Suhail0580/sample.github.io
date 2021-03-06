<?php
/**
 *
 * The template part for displaying the dashboard menu
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */

global $current_user;

$reference 		 = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : '';
$mode 			 = (isset($_GET['mode']) && $_GET['mode'] <> '') ? $_GET['mode'] : '';
$user_identity 	 = $current_user->ID;
?>
<li class="<?php echo esc_attr( $reference  === 'payouts-settings' ? 'dc-active' : ''); ?>">
	<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('payouts', $user_identity,'','settings'); ?>">
		<i class="ti-credit-card"></i>
		<span><?php esc_html_e('Payouts Settings','doctreat');?></span>
	</a>
</li>
