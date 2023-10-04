<?php

/*
 * Plugin Name:       My Basics Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
 
 
 /*
{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {URI to Plugin License}.
*/

if (!defined ('ABSPATH')) {
	header('location: /');
	die();
}


// activation function
function my_plugin_activation(){
		global $wpdb, $table_prefix; //$wpdb database connection
		$wp_emp = $table_prefix.'emp'; //$table_prefix Table prefix e.g wp_

		$q = "CREATE TABLE IF NOT EXISTS `$wp_emp` (`ID` AUTO_INCREMENT, `name` varchar(50), `email` varchar(50), `status` BOOLEAN,
		PRIMARY KEY (`ID`)) ENGINE = MyISAM,";
		$wpdb-> query($q); //to run Query


		$data = array(
			'name' => 'Ali',
			'email' => 'ali@gmail.com',
			'status' => 1,
		);

		$wpdb->insert($wp_emp, $data);


}

//Activation
register_activation_hook(
	__FILE__,
	'my_plugin_activation'
	// 'pluginprefix_function_to_run'
);


//Deactivation Function
function my_plugin_deactivation(){
	global $wpdb, $table_prefix;
	$wp_emp = $table_prefix."emp";

	$q = "TRUNCATE `$wp_emp`"; //clear the table
	$wpdb->query($q);

}
//Deactivation
register_deactivation_hook(
	__FILE__,
	'my_plugin_deactivation'
	// 'pluginprefix_function_to_run'
);







// shortcode

function my_sc_func(){
	include ('shortcode.html');
}
add_shortcode('my-shortcode', 'my_sc_func'); //my-shortcode is shortcode and my_sc_func is function to perform action



//include file

function custom_scripts(){
	 $path_js = plugins_url("js/main.js", __FILE__);
	 $path = plugins_url("css/style.css", __FILE__);
	 $dep = arry('jquery'); //dependencies
	 $ver_js = filemtime(plugin_dir_path(__FILE__).'js/main.js'); //version
	 $ver = filemtime(plugin_dir_path(__FILE__).'css/style.css'); //version
	 wp_enqueue_script('my-custom-js', $path_js,$path, $dep, $ver_js,$var true);
	 //User login condition
	 $is_login = is_user_logged_in() ? 1:0;
}
add_action('wp_enqueue_scripts', 'custom_scripts'); //hook
add_action('admin_enqueue_scripts', 'custom_scripts'); //hook for load in admin


//Show records from db
function show(){
	global $wpdb, $table_prefix;
	$wp_emp = $table_prefix. "emp";

	$q = "SELECT * FROM `$wp_emp`;";
	$results = $wpdb->get_results($q);

	ob_start()
	?>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($results as $row):
			?>
			<tr>
				<td><?php echo "$row->ID;"  ?></td>
				<td><?php echo "$row->name;"  ?></td>
				<td><?php echo "$row->email;"  ?></td>
			</tr>
			<?php
			endforeach
			?>
		</tbody>
	</table>
	<?php
	$html = ob_get_clean();
	return $html;


	function posts(){
		$args =(
			'post_type'=>'post',
			'post_per_page'=> 3,
			'order'=>'ASC'
		);
		$query = new WP_Query($args);
		
		ob_start()
		if ($query->have_post()):
		?>
		<ul>
			<?php
			while($query->have_post()){
				$query->the_post();
				echo '<li>'.get_the_tittle().'->'.get_the_content(). '</li>';
			}
			?>
		</ul>
		<?php
	}
}
add_shortcode('showresult', 'show');

//viewa
function head_fun(){
	 if(is_single()){
		global $post;
		$views = get_post_meta($post->ID, 'views', true);

		if($views ==''){
			add_post_meta($post->ID,'views', 1)
		}else{
			$views ++;
			update_post_meta($post->ID, $views);
		}
	 }
}
add_action('wp_head', 'head_fun');//1st arg hook and 2nd one is function

//Use this [views-count] shortcode to check post visited.
function views_count{
	global $post;
	return 'Total Views: '.get_post_meta($post->ID, 'views', true);
}
add_shortcode('view-count', 'views_count');

function my_plugin_page_func(){

}


//Add in menu
function my-plugin-subpage-func(){
	echo "my-plugin-subpage-func";
	//include 'subpage.html'; //To include html page
}

function my_plugin_page_func(){
	echo 'my_plugin_page_func';
}

function my_plugin_menu(){
	add_menu_page('My Plugin Page', 'My plugin Page', 'manage_options',
	'my_plugin_page', 'my_plugin_page_func', 6);
	//page tittle, menu tittle, capabilitie(admin,editor, etc), menu slug, call back function, location

	add_sumenu_page('my-plugin-page', 'My Plugin Sub Page', 'My Plugin Sub Page',
	 'manage_options', 'my-plugin-subpage','my-plugin-subpage-func')
}

add_action('admin_menu','my_plugin_menu');


//