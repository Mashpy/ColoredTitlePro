<?php
/*
Plugin Name: FinitePi Colored Title Pro
Plugin URI: http://liton-online.com/plugins
Description: This is a demo description.
Version: 1.0 Author: Md. Liton Arefin
Author URI: http://liton-online.com
*/
/** Step 2 (from text above). */


add_filter("the_title", FPI_the_title, 10, 2 );
function FPI_the_title($title, $id) {
	return '<span style="color:Red">'.$title.'</span>';
}

register_activation_hook( __FILE__, 'FPI_TitleColor_Activated');
function FPI_TitleColor_Activated(){
	$defaultColors=array( 	'Front' => 'Red',
			'Page' => 'Green',
			'Post' => 'Blue',
			'Others' => 'Gray' );
	add_option('FPI_TitleColor_Options' ,$defaultColors );

}

register_deactivation_hook(__FILE__, 'FPI_TitleColor_Deactivated');
function FPI_TitleColor_Deactivated(){
	delete_option('FPI_TitleColor_Options');
}
add_action('admin_menu', 'FPI_TitleColor_Option_Page_menu');
function FPI_TitleColor_Option_Page_Menu(){
	add_options_page( 'Finitepi Colored Title Option Page', 'FPI Title Colors', 'manage_options', 'fpi-titlecolor-option-page' , 'FPI_TitleColor_Option_page_setup' );
}

function FPI_TitleColor_option_page_setup()
{ ?>

	<div class = "wrap">
		<h2>Finist set Colored title Option Page </h2>
    <form method="post" action="options.php" >
<?php settings_fields('fpi-titlecolor-settings');  ?>
<?php do_settings_sections('fpi-titlecolor-option-page'); ?>
<?php submit_button(); ?>
</form>
	</div>
<?php }
                               
add_action('admin_init', 'FPI_TitleColor_Settings_Init' );
function FPI_TitleColor_Settings_Init(){
	add_settings_section('FPI-TitleColor-Section', 'Colors for different post titles', 'FPI_TitleColor_Settings_Setup', 'fpi-titlecolor-option-page');
  
  add_settings_field('FPi-front-ID', 'Front Page Title Color', 'FinitePi_TextBox', 'fpi-titlecolor-option-page', 'FPI-TitleColor-Section', array ('name' => 'Front')) ;
  
  add_settings_field('FPi-Page-ID', ' Page Title Color', 'FinitePi_TextBox', 'fpi-titlecolor-option-page', 'FPI-TitleColor-Section', array ('name' => 'Page')) ;
  
  add_settings_field('FPi-Post-ID', 'Post Page Title Color', 'FinitePi_TextBox', 'fpi-titlecolor-option-page', 'FPI-TitleColor-Section', array ('name' => 'Post')) ;
  
  add_settings_field('FPi-Others-ID', 'Other Page Title Color', 'FinitePi_TextBox', 'fpi-titlecolor-option-page', 'FPI-TitleColor-Section', array ('name' => 'Others')) ;
  
  register_setting('fpi-titlecolor-settings', 'FPI_TitleColor_Options', 'FPI_TitleColor_Validation');
  
}


function FPI_TitleColor_Settings_Setup(){
	echo '<p> Set the title colors for front, page and post </p>';
}

function FinitePi_TextBox($args){
extract($args);
  $optionArray= (array)get_option('FPI_TitleColor_Options');
	$current_value= $optionArray[$name];
	echo '<input type="text" name="FPI_TitleColor_Options['.$name.']" value="'.$current_value.'"/>';

}

function FPI_TitleColor_Validation($input){
$temp=trim($input['front']);
if(empty($temp))
	$input['front'] = 'red';

$temp=trim($input['Page']);
if(empty($temp))
	$input['Page'] = 'red';

$temp=trim($input['Post']);
if(empty($temp))
	$input['Post'] = 'red';

$temp=trim($input['Others']);
if(empty($temp))
	$input['Others'] = 'red';

return $input;

}
                       

