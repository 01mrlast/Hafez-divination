<?php

use DHafez\Option;

/**
 * @param $option_name
 *
 * @return string
 */
function DHafez_get_option( $option_name ) {
	return Option::get( $option_name );
}
function hafez() {
    global $wpdb;
    $table_name = $wpdb->prefix . "Hafez";

if(isset($_POST['hafez'])){

  $result = $wpdb->get_results ( "
    SELECT * FROM `$table_name` ORDER BY RAND() LIMIT 1
" );
    foreach ( $result as $page )
{
   echo "<center style='direction:rtl'>".$page->title.'<br/>';
   echo $page->content.'</center><br/>';
}

}else{

}

}
add_shortcode( 'hafez', 'hafez' );