<div id="container">
  <div id="list">
<?php
$_cat_to_be_show=$_REQUEST["cat_to_be_show"];
$_cat_to_be_del_name=$_REQUEST["cat_to_be_del_name"];
if(isset($_REQUEST["cat_to_be_show_$_cat_to_be_show"]) and !isset($_REQUEST["updt"]))
{
$_cat_to_be_show=$_REQUEST["cat_to_be_show"];
$_cat_to_be_del_name=$_REQUEST["cat_to_be_del_name"];
?>   
<form action="" method="post"> 
  <ul class="ui-sortable">
<?php
$args = array('posts_per_page' => -1,  'category' => $_cat_to_be_show ,  'post_status' => 'publish');
global $wpdb;
$query="select * from wp_term_relationships where term_taxonomy_id=11";
$myposts=$wpdb->get_results($query);
$myposts = get_posts( $args );
krsort($myposts);
foreach ( $myposts as $post ) : setup_postdata( $post ); 
	echo "<li id=\"arrayorder_$post->ID\">";
		 echo $post->post_title;
		  
		 echo "<input type=\"hidden\" name=\"arrayorder[]\" value=\"$post->ID\">";
		 echo "<input type=\"hidden\" name=\"cat_id\" value=\"$_cat_to_be_show\">";
	echo "</li>";
endforeach; 
wp_reset_postdata();
global $wpdb;
			$wp_query  = "SELECT * FROM wp_WP_POST_PORDERED where cat_id=$_cat_to_be_show";
				$results = $wpdb->get_results($wp_query);

			
				if(count($results) > 0)
                {
global $wpdb;
	$wp_del_cat="delete from wp_WP_POST_PORDERED where cat_id=$_cat_to_be_show";
$wpdb->query($wp_del_cat);
rsort($myposts);
foreach ( $myposts as $post ) : setup_postdata( $post ); 
	$wp_insert="insert into wp_WP_POST_PORDERED (cat_id , post_id , list_order) values ($_cat_to_be_show , $post->ID , $post->ID)";
$wpdb->query($wp_insert);
endforeach; 
wp_reset_postdata();



}
else
{
rsort($myposts);
		global $wpdb;
foreach ( $myposts as $post ) : setup_postdata( $post ); 
	$wp_insert="insert into wp_WP_POST_PORDERED (cat_id , post_id , list_order) values ($_cat_to_be_show , $post->ID , $post->ID)";
$wpdb->query($wp_insert);
endforeach; 
wp_reset_postdata();


}
?>		
    
				
	 
    </ul>
<input type="submit" name="updt" value="save" class="updts"/>
</form>

<?php } 

else if(isset($_REQUEST["updt"]))
{
$cat_id=$_REQUEST["cat_id"];
global $wpdb;
$x=$_REQUEST["arrayorder"];
$_cat_to_be_show=$_REQUEST["cat_id"];
$query="select * from wp_WP_POST_PORDERED where cat_id=$_cat_to_be_show";
$results=$wpdb->get_results($query);
$count=0;
foreach($results as $r)
{



$update="update wp_WP_POST_PORDERED set list_order=$x[$count] where post_id=$r->post_id and cat_id=$_cat_to_be_show";
$wpdb->query($update);
$count++;
}

?>

<form action="" method="post"> 
  <ul class="ui-sortable">
<?php

global $wpdb;
$myposts="select * from wp_WP_POST_PORDERED where cat_id=$cat_id ";
$results=$wpdb->get_results($myposts);

foreach ( $results as $post ) 
{

	echo "<li id=\"arrayorder_$post->list_order\">";
		 echo get_the_title($post->list_order);

		 echo "<input type=\"hidden\" name=\"arrayorder[]\" value=\"$post->list_order\">";
		 echo "<input type=\"hidden\" name=\"cat_id\" value=\"$cat_id\">";
	echo "</li>";
}


?>		
    
				
	 
    </ul>
<input type="submit" name="updt" value="save" class="updts"/>
</form>
<?php
$cat_id=$_REQUEST["cat_id"];
$yourcat = get_category($cat_id);

?>
<div id="mask"></div>
<div id="popupwindow">
<div class="pop_1">
<div class="link" style="border:0px solid #9E013D;width:94%;height:45px;position:relative; display:block;  margin: 186px auto 6px;" >
<span style="color:#fff;font-size:12px;text-align:left;font-weight:bold;bottom:87px;left:17%;position:relative;background:#288FBE">Posts order has been saved for the category&nbsp;[<?php echo $yourcat->name;?>].Please click the continue button</span>
<form name="update_verify" action="" method="post">
<div class="btns" style="float: left;margin-left: 175px;margin-right: 105px;
  width: 36%
">
<input type="submit" name="fup" value="Continuee" class="update" title="Please click this button  to continuee "/>
<input type="hidden" name="cat_id" value="<?php echo $_cat_to_be_show ;?>"/>

</div>

</form> 
</div>
</div>
</div>
<?php
}
else if(isset($_REQUEST["fup"]))
{
$cat_id=$_REQUEST["cat_id"];
$yourcat = get_category($cat_id)
?>

<form action="" method="post"> 
  <ul class="ui-sortable">
<?php

global $wpdb;
$myposts="select * from wp_WP_POST_PORDERED where cat_id=$cat_id ";
$results=$wpdb->get_results($myposts);

foreach ( $results as $post ) 
{

	echo "<li id=\"arrayorder_$post->list_order\">";
		 echo get_the_title($post->list_order);
		
		 echo "<input type=\"hidden\" name=\"arrayorder[]\" value=\"$post->list_order\">";
		 echo "<input type=\"hidden\" name=\"cat_id\" value=\"$cat_id\">";
	echo "</li>";
}


?>		
    
				
	 
    </ul>
<input type="submit" name="updt" value="save" class="updts"/>
</form>





<?php
}



else {?>


<p class="list_home_h2">
    <h2>Welcome to the post arranger</h2>
    </p>
	<p class="list_home_h2">
	On <span>RIGHT-SIDE</span> you can see the  category
that 	is visible. Just press the 
	<span>show posts</span> button to see  the posts of that category for 
which you want to order	the posts .</p>
	<p>Note: the category that is selected and saved, the</p>
	      <p>corresponding posts of that category will be 
		  visible in <span>posts arranger</span> option where you have to 
		  simply drag the posts title and the order will be
		  saved automatically. 
		   <p><span>Hope the above explanation is clear and make sense</span>.</p>


<?php } ?>
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
if(isset($_REQUEST["cat_to_be_show_$result->cat_id"]))
{
	echo "<li style=\"background:#009F58\">$result->cat_name<form action=\"\" method=\"post\" class=\"cat_to_be_del\"><input type=\"submit\" name=\"cat_to_be_show_$result->cat_id\" value=\"showing posts\" style=\"color:black\"><input type=\"hidden\" name=\"cat_to_be_show\" value=\"$result->cat_id\"/><input type=\"hidden\" name=\"cat_to_be_del_name\" value=\"$result->cat_name\"/></form></li>";
}
else if(isset($_REQUEST["updt"]) and $result->cat_id==$_REQUEST["cat_id"])
{
	echo "<li style=\"background:#009F58\">$result->cat_name<form action=\"\" method=\"post\" class=\"cat_to_be_del\"><input type=\"submit\" name=\"cat_to_be_show_$result->cat_id\" value=\"showing posts\" style=\"color:black\"><input type=\"hidden\" name=\"cat_to_be_show\" value=\"$result->cat_id\"/><input type=\"hidden\" name=\"cat_to_be_del_name\" value=\"$result->cat_name\"/></form></li>";
}
else if(isset($_REQUEST["fup"]) and $result->cat_id==$_REQUEST["cat_id"])
{
	echo "<li style=\"background:#009F58\">$result->cat_name<form action=\"\" method=\"post\" class=\"cat_to_be_del\"><input type=\"submit\" name=\"cat_to_be_show_$result->cat_id\" value=\"showing posts\" style=\"color:black\"><input type=\"hidden\" name=\"cat_to_be_show\" value=\"$result->cat_id\"/><input type=\"hidden\" name=\"cat_to_be_del_name\" value=\"$result->cat_name\"/></form></li>";
}
else
{

echo "<li>$result->cat_name<form action=\"\" method=\"post\" class=\"cat_to_be_del\"><input type=\"submit\" name=\"cat_to_be_show_$result->cat_id\" value=\"show posts\"><input type=\"hidden\" name=\"cat_to_be_show\" value=\"$result->cat_id\"/><input type=\"hidden\" name=\"cat_to_be_del_name\" value=\"$result->cat_name\"/></form></li>";
}	
}
?>
</ul>
</div>
<?php
}
	?>

</div>



<?php
if(isset($_REQUEST["updt"]))
{
?>
<div id="updt">
<?php
echo "All saved! changes has been saved";
?>
</div>



<?php
}


?>
<?php
if(isset($_REQUEST["fup"]))
{
$cat_id=$_REQUEST["cat_id"];
$yourcat = get_category($cat_id);
?>
<div id="updt">
<?php


echo "All saved! changes has been saved for the category&nbsp;[$yourcat->name]";
?>
</div>
<?php
}
?>



</div>

<?php require_once 'require_once.php' ;?>

