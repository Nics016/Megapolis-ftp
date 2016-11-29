<?php
	get_header();

	global $wpdb;

	$xss = $wpdb->get_results("SELECT xss FROM test WHERE ID = 2", 'ARRAY_A');
	$xss = $xss[0]['xss'];

	echo $xss;



?>


 <form action="" id="form" style="display: block; width: 400px; margin: 0 auto;">
	<input type="text" name="xss">
	<input type="submit" value="погнали">
</form> 

<?php
	get_footer();
?>