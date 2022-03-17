<?php
/**
 * Template Name: Download PDF
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://codecanyon.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat APP
 *
 */
if( isset($_GET['download_prescription_id']) ){ 
?>
<!doctype html>
<html>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<title><?php esc_html_e('Download Prescription','doctreat_api');?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
	<div  style="display:none;">
	  <form method="post" name="download_pdf" id="download_pdf">
		<input type="hidden" name="pdf_booking_id" value="<?php echo intval($_GET['download_prescription_id']);?>">
		<a href="javascript:;" onclick="document.forms['download_pdf'].submit(); return false;" class="dc-btn dc-pdfbtn"><i class="ti-download"></i></a>
	  </form>
	 </div>               
	<script type="text/javascript">setTimeout(function(){document.getElementById("download_pdf").submit();}, 1500);</script>
	</body>
</html>
<?php } ?>