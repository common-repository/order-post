<?php
/*
Plugin Name: ORDER POST
Plugin URI: http://www.phpphobia.blogspot.com
Description: Wordpress plugin to arrange or order the visibility of posts of a particular category
Author: vikashsrivastava1111989 
Version: 2.0.2
Author URI: http://www.phpphobia.blogspot.com
*/
?>
<?php
$siteurl = get_option('siteurl');
if ( ! defined( 'WP_POST_FOLDER' ) )
	define('WP_POST_FOLDER', dirname(plugin_basename(__FILE__)));

if ( ! defined( 'WP_POST_URL' ) )
	define('WP_POST_URL', $siteurl.'/wp-content/plugins/' . WP_POST_FOLDER);

if ( ! defined( 'WP_POST_FILE_PATH' ) )
	define('WP_POST_FILE_PATH', dirname(__FILE__));

if ( ! defined( 'WP_POST_DIR_NAME' ) )
define('WP_POST_DIR_NAME', basename(WP_POST_FILE_PATH));

global $wpdb;
$WP_POST_table_prefix=$wpdb->prefix.'WP_POST_';
$image_path=dirname(plugin_basename(__FILE__));
if ( ! defined( 'WP_POST_TABLE_PREFIX' ) )
define('WP_POST_TABLE_PREFIX', $WP_POST_table_prefix);
register_activation_hook(__FILE__,'WP_POST_install');
register_deactivation_hook(__FILE__ , 'WP_POST_uninstall' );
function WP_POST_install()
{
global $wpdb;
$table = WP_POST_TABLE_PREFIX."PO";
$structure = "CREATE TABLE $table (
  `id` int(11) NOT NULL auto_increment,
  `cat_name` varchar(1024) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;";
$wpdb->query($structure);
$table_posts = WP_POST_TABLE_PREFIX."PORDERED";
$structure_posts = "CREATE TABLE $table_posts (
  `id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `list_order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;";
$wpdb->query($structure_posts);
}
function WP_POST_uninstall()
{
global $wpdb;
$table = WP_POST_TABLE_PREFIX."PO";
$structure = "drop table if exists $table;";
$wpdb->query($structure);  
$table_posts = WP_POST_TABLE_PREFIX."PORDERED";
 $structure_posts = "drop table if exists $table_posts;"; 
$wpdb->query( $structure_posts);  
}
add_action('admin_menu','WP_POST_admin_menu');
function WP_POST_admin_menu(){ 
add_menu_page(
"Add category",
"Add category",
8,
__FILE__,
"WP_POST_admin_add_template");
add_submenu_page(__FILE__,'order post','order post','8','list-posts','WP_POST_admin_list_template');
}
function WP_POST_admin_add_template()
{
?>
<div id="container">
<div id="list_home">
<p class="list_home_h2">
    <h2>Welcome to the post arranger</h2>
    </p>
	<p class="list_home_h2">
	Below you can see the list of all the categories
	You can select any category and just press the 
	<span>save</span> button to add the category you want to order
	the posts .</p>
	<p>Note: the category that is selected and saved, the</p>
	      <p>corresponding posts of that category will be 
		  visible in <span>posts arranger</span> option where you have to 
		  simply drag the posts title and the order will be
		  saved automatically if you go to the posts arranger 
		  option you will get the <span>shortcode</span> just place this <span>shortcode</span> in place of your <span>normal query posts</span> that you will write to populate your posts of this category and your posts will be ordered according to your set order using this plugin.</p>
		  
		 <p>Hope the above explanation is clear and make sense.</p>
	<p><h3>Category Lists:</h3></p>
	
<div class="cat_list_home">
<div class="cat_lists">
<?php
echo "<form action=\"\" method=\"post\"><div class=\"ups\">";
wp_dropdown_categories(array('hide_empty' => 0, 'name' => 'category_parent', 'orderby' => 'name', 'selected' => $category->parent, 'hierarchical' => true,'show_option_none' => __('None')));
echo "</div><div class=\"ups\"><input type=\"submit\" name=\"cat_sel\" value=\"save\" class=\"updt\"/>
</div></form>";
?>
</div>
</div>
<?php
if(isset($_REQUEST["cat_sel"]))
{
$term_taxonomy_id=$_REQUEST["category_parent"];
if($term_taxonomy_id==-1)
{
?>
<div class="status_update_error">
<?php
echo "please select any categoty. No category selected yet...";
?>
</div>
<?php
}
else
{
$cat=$term_taxonomy_id;
$yourcat = get_category($cat);
if ($yourcat) {
global $wpdb;
$wp_fetch_query="select * from wp_WP_POST_PO where cat_id=$cat ";
$results = $wpdb->get_results($wp_fetch_query);
if(count($results) >0)
{
?>

<?php
echo "<div class=\"cat_already\">$yourcat->name &nbsp; is already added...!</div>";
?>

<?php
}
else
{
global $wpdb;
$wp_add_query="insert into wp_WP_POST_PO (cat_name , cat_id) values ('$yourcat->name' , $cat)";
$wpdb->query($wp_add_query);
?>
<div class="status_update">
<?php echo  $yourcat->name ;echo"&nbsp;is added successfully...";?>
</div>
<?php
}
} 
}
}
if(isset($_REQUEST["cat_to_be_del"]))
{
  $cat_to_be_del=$_REQUEST["cat_to_be_del"];
  $cat_to_be_del_name=$_REQUEST["cat_to_be_del_name"];
  global $wpdb;
  $wp_del="delete from wp_WP_POST_PO where cat_id=$cat_to_be_del";
  $wpdb->query($wp_del);
  $wp_del_posts="delete from wp_WP_POST_PORDERED where cat_id=$cat_to_be_del";
  $wpdb->query($wp_del_posts);
  ?>
  <div class="status_update">
  <?php
echo "$cat_to_be_del_name &nbsp; is successfully Removed";  
?>
</div>
<?php
}
?>
<div class="shortcode_area">
<div class="message">
<p><h3><span>Shortcode Panel</span></h3></p>
<p>Here you will get all the <span>shortcodes</span> for the categories that you have added through this plugin just paste this <span>Shortcodes</span> either in <span>Posts</span>,<span>Templates</span>,<span>Widget</span>,<span>Comments</span> and you will get all the posts ordered according to the order that you have set in <span>Post Arranger</span> option </p>
</p><span>How to use</span></p>
1. Inside the php page : <span>&lt;?php echo do_shortcode('[vs-posts-order&nbsp;vs_limit="limit_number"&nbsp; 
 vs_cat="category_number_generated"]') ;?&gt;</span>
<br>
<br>
 2. Inside the posts : <span>[vs-posts-order vs_limit="limit_number" vs_cat="category_no_generated"]</span>
 <br>
<p><span style="color:red" class="user_can_change">Note*</span>: 1. You can set the limit of the posts by entering the value corresponding to the <span>vs_limit</span>, that how many posts that you want to display. <span>Default</span> limit is <span>1</span>.
<br><br>
2. Do not remove the  value corresponding to the parameter <span>vs_cat</span> If you will change or remove, the plugin will either not work or display the posts of <span>Uncategorized</span></p> 
</div>

<?php
global $wpdb;
$wp_query="select * from wp_WP_POST_PO";
$results=$wpdb->get_results($wp_query);
if(count($results) ==0)
{
echo "<span class=\"admin_define\" style=\"color:red;font-weight:normal\">Current status :&nbsp;No categories selected Yet. Please select a category...!</span>";
}
else if(count($results) >0)
{
echo "<ul class=\"cat_short\">";
$count=1;
foreach($results as $result)
{
$cat_name=get_category($result->cat_id);
?>
<script>
  function selectText(containerid) {
        if (document.selection) {
            var range = document.body.createTextRange();
            range.moveToElementText(document.getElementById(containerid));
            range.select();
        } else if (window.getSelection) {
            var range = document.createRange();
            range.selectNode(document.getElementById(containerid));
            window.getSelection().addRange(range);
        }
    }
</script>

<div class="shortcode_section">
<?php
echo "<li class=\"cat_li_short\" id=\"cat_li_short_$result->id\"><span>$count .</span>&nbsp;<span class=\"short_codes\" id=\"short_codes_$count\" onclick=\"selectText('short_codes_$count')\">[vs-posts-order vs_limit=\"1\" vs_cat=\"$result->cat_id\"]</span> &nbsp;<span class=\"cat_desc\">this is for the category &nbsp;$cat_name->name</span></li>";
$count++;
}
echo "</ul>";
}
?>
</div>
</div>
<div class="cat_added_panel">
<h3 class="cat_a_p">Categories Added</h3>
<?php
global $wpdb;
$wp_fetch_query="select * from wp_WP_POST_PO  ";
$results = $wpdb->get_results($wp_fetch_query);
if(count($results) ==0)
{
echo "<div class=\"cat_not_added_yet\">There is no category added...</div>";
}
else
{
?>
<div class="cat_added_list">
<ul class="cat_ul">
<?php
global $wpdb;
foreach($results as $result)
{
echo "<li>$result->cat_name<form action=\"\" method=\"post\" class=\"cat_to_be_del\"><input type=\"submit\" name=\"cat_to_be_del\" value=\"Remove\"><input type=\"hidden\" name=\"cat_to_be_del\" value=\"$result->cat_id\"/><input type=\"hidden\" name=\"cat_to_be_del_name\" value=\"$result->cat_name\"/></form></li>";
}
?>
</ul>
</div>
<?php
}
?>
</div>
<div class="promo_and_about">
<div class="About_the_author_head">
<span>About Author</span>
</div>
<div class="About_the_author_image">
<img src="<?php $plugin_url=plugins_url()."/wp_post_order"; echo "$plugin_url" ;?>/images/vikashsrivastava.jpeg" width="80px" height="80px"/>
<p>This plugin is created by Vikash Srivastava . Working as PHP , Mysql Developer for more

than 2-Years. </p>
<p>
Please for any enquiry and feedback visit <a href="http://www.phpphobia.blogspot.com" target="_blank" title="Author blog">
http://www.phpphobia.blogspot.com</a>
<p><div id="fb-root"></div>
<div id="fb-root"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=555767771112468";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><div class="fb-like" data-href="https://www.facebook.com/anybodycancode" data-width="450" data-show-faces="true" data-send="true"></div></p>
</p>
</div>
</div>

</div>
<?php
require_once 'require_home_wp.php';
}
function WP_POST_admin_list_template()
{
include 'wp-list-posts.php';
}
function wp_posts_order_function($atts){
extract(shortcode_atts(
array('vs_limit' => 1,'vs_cat' => 1,), $atts));
echo "<ul class=\"ui-sortable\">";
global $wpdb;
$myposts="select * from wp_WP_POST_PORDERED where cat_id=$vs_cat limit $vs_limit ";
$results=$wpdb->get_results($myposts);
foreach ( $results as $post ) 
{
echo "<li id=\"arrayorder_$post->list_order\">";
echo get_the_title($post->list_order);
echo "<input type=\"hidden\" name=\"arrayorder[]\" value=\"$post->list_order\">";
echo "<input type=\"hidden\" name=\"cat_id\" value=\"$vs_cat\">";
echo "</li>";
}
echo "</ul>";
}
function register_shortcodes(){
add_shortcode('vs-posts-order', 'wp_posts_order_function');
}
add_action( 'init', 'register_shortcodes');
add_filter('widget_text', 'do_shortcode');
add_filter( 'the_excerpt', 'do_shortcode');
add_filter( 'comment_text', 'do_shortcode' );
?>
