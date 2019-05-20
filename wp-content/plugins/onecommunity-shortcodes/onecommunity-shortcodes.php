<?php
/**
* Plugin Name: OneCommunity Shortcodes
* Plugin URI: http://themeforest.net/user/Diabolique
* Description: This plugin adds shortcodes.
* Version: 1.0.4
* Author: Diabolique Design
* Author URI: http://themeforest.net/user/Diabolique
*/


function onecommunity_shortcodes_load_plugin_textdomain() {
    load_plugin_textdomain( 'onedcommunity-shortcodes', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'onecommunity_shortcodes_load_plugin_textdomain' );


function add_DD_shortcodes_style() {
	wp_register_style( 'DDShortcodes', plugins_url('shortcodes.css', __FILE__) );
	wp_enqueue_style( 'DDShortcodes' );
}
add_action( 'wp_enqueue_scripts', 'add_DD_shortcodes_style' );


function onecommunity_shortcode_scripts(){
  if (!is_admin()) {
   wp_enqueue_script('eqcss-polyfill',plugin_dir_url( __FILE__ ).'js/EQCSS-polyfills.min.js',false,'1.6.0',true);
   wp_script_add_data( 'eqcss-polyfill', 'conditional', 'lt IE 9' );
   wp_enqueue_script('eqcss',plugin_dir_url( __FILE__ ).'js/EQCSS.min.js',false,'1.6.0',true);  
   wp_enqueue_script('jquery-masonry');
   wp_enqueue_script('shortcode-scripts',plugin_dir_url( __FILE__ ).'js/scripts.js',false,'2.0',true);
  }
}
add_action('init','onecommunity_shortcode_scripts');


add_filter('widget_text', 'do_shortcode');
add_filter( 'bp_get_the_topic_post_content', 'do_shortcode' );
add_filter( 'bp_get_group_description', 'do_shortcode' );



add_filter("the_content", "the_content_filter");

function the_content_filter($content) {

// array of custom shortcodes requiring the fix
$block = join("|",array("img","go","quoteby","clear","highlight","quote","leftpullquote","rightpullquote","member","h1","h2","h3","h4","h5","h6","one_third","one_third_last","two_third","two_third_last","one_half","one_half_last","one_fourth","one_fourth_last","three_fourth","three_fourth_last","one_fifth","one_fifth_last","two_fifth","two_fifth_last","three_fifth","three_fifth_last","four_fifth","four_fifth_last","one_sixth","one_sixth_last","five_sixth","five_sixth_last"
));

// opening tag
$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
// closing tag
$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

return $rep;

}


function myGo($atts, $content = null) {
	extract(shortcode_atts(array(
		"href" => 'http://'
	), $atts));
	return '<div class="shortcode_go"><a href="'.$href.'">'.$content.'</a></div>';
}

add_shortcode("go", "myGo");


function myQuoteBy($atts, $content = null) {
	extract(shortcode_atts(array(
		"by" => ''
	), $atts));
	return '<div class="shortcode_quoteby"><div class="shortcode_quotebyauthor">'.$by.'</div>'.$content.'</div>';
}

add_shortcode("quoteby", "myQuoteBy");


function myImage($atts, $content=null, $code="") {
	$return = '<div class="my-image"><a href="'.$content.'"><img src="'.$content.'" alt="Image" />';
	$return .= '</a></div>';
	return $return;
}
add_shortcode('img' , 'myImage' );


function myClear() {return '<div class="clear"></div>';}
add_shortcode('clear', 'myClear');


function highlighttext($atts, $content=null, $code="") {
	$return = '<span class="shortcode_highlight">';
	$return .= $content;
	$return .= '</span>';
	return $return;
}

add_shortcode('highlight' , 'highlighttext' );


function noticetext($atts, $content=null, $code="") {
	$return = '<div class="shortcode_notice">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('notice' , 'noticetext' );


function quotetext($atts, $content=null, $code="") {
	$return = '<div class="shortcode_quote">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('quote' , 'quotetext' );


function leftpullquotes($atts, $content=null, $code="") {
	$return = '<div class="leftpullquote">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('leftpullquote' , 'leftpullquotes' );


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function rightpullquotes($atts, $content=null, $code="") {
	$return = '<div class="rightpullquote">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('rightpullquote' , 'rightpullquotes' );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function member_check_shortcode( $atts, $content = null ) {
       if ( is_user_logged_in() && !is_null( $content ) && !is_feed() ) {
	return '<div class="shortcode_member">' . $content . '</div>';
	} else {
	return '<div class="shortcode_no-member">This content is visible for members only</div>';
	}
      return '';
}

add_shortcode( 'member', 'member_check_shortcode' );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onecommunity_blog_categories($atts, $content = null) {

ob_start();
$cats = explode("<br />",wp_list_categories('title_li=&echo=0&depth=1&style=none'));
$cat_n = count($cats) - 1;
$cat_left = '';
$cat_right = '';
for ($i=0;$i<$cat_n;$i++):
if ($i<$cat_n/2):
$cat_left = $cat_left.'<li>'.$cats[$i].'</li>';
elseif ($i>=$cat_n/2):
$cat_right = $cat_right.'<li>'.$cats[$i].'</li>';
endif;
endfor;
?>

<ul id="blog-categories-left">
<?php echo $cat_left; ?>
</ul>
<ul id="blog-categories-right">
<?php echo $cat_right; ?>
</ul>
<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-blog-categories", "onecommunity_blog_categories");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onecommunity_login($atts, $content = null) {

ob_start();

if ( is_user_logged_in() ) : ?>
<?php else : ?>

<div id="shortcode-login">

	<div id="shortcode-login-title"><?php _e('Log In', 'onecommunity-shortcodes'); ?></div>
	<div id="shortcode-login-desc"><?php _e('Login to your account and check new messages.', 'onecommunity-shortcodes'); ?></div>

		<?php do_action( 'bp_before_sidebar_login_form' ) ?>

		<form name="login-form" id="shortcode-login-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ) ?>" method="post">
			<label><?php _e( 'Username', 'onecommunity-shortcodes' ) ?>:<br />
			<input type="text" name="log" id="shortcode-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

			<label><?php _e( 'Password', 'onecommunity-shortcodes' ) ?>:<br />
			<input type="password" name="pwd" id="shortcode-user-pass" class="input" value="" tabindex="98" /></label>

			<div class="forgetmenot">
			<div><label><input name="rememberme" type="checkbox" id="shortcode-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'onecommunity-shortcodes' ) ?></label></div>
			<a href="<?php echo home_url(); ?>/<?php _e( 'recovery', 'onecommunity-shortcodes' ); ?>" class="shortcode-password-recovery"><?php _e( 'Password Recovery', 'onecommunity-shortcodes' ); ?></a>
			</div>

			<?php do_action( 'bp_sidebar_login_form' ) ?>
			<input type="submit" name="wp-submit" id="shortcode-login-submit" value="<?php _e( 'Log In', 'onecommunity-shortcodes' ); ?>" tabindex="100" />
		</form>

		<?php do_action( 'bp_after_sidebar_login_form' ) ?>

</div><!-- shortcode-login -->

<?php endif;

$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-login", "onecommunity_login");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onecommunity_recent_forum_topics($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_topics" => '5'
	), $atts));
ob_start();
	if ( bbp_has_topics( array( 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'post_parent' => 'any', 'paged' => 1, 'posts_per_page' => $number_of_topics ) ) ) :
		bbp_get_template_part( 'loop', 'mytopics' );
	else :
		bbp_get_template_part( 'feedback', 'no-topics' );
	endif;
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-recent-forum-topics", "onecommunity_recent_forum_topics");




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function onecommunity_recent_blog_posts($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_blog_posts" => '5'
	), $atts));

ob_start(); ?>

<div class="onecommunity-recent-posts-container">

<?php
$wp_query = '';
$paged = '';
$temp = $wp_query;
$wp_query= null;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=' . $number_of_blog_posts . ''.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<div class="recent-post">
         <div class="recent-post-thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a></div>
       	 <div class="recent-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		 <div class="recent-post-bottom"><div class="recent-post-time"><?php the_time('F j, Y') ?></div></div></div>
	</div>

<?php endwhile; // end of loop
wp_reset_query(); ?>

</div>

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}

add_shortcode("onecommunity-recent-blog-posts", "onecommunity_recent_blog_posts");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onecommunity_bp_groups_listing($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_groups" => '8'
	), $atts));

if ( function_exists( 'bp_is_active' ) ) {
ob_start(); ?>
<div id="tabs-container" class="shortcode-bp-groups-tabs-container">

<div class="object-nav-container">
<div id="object-nav">
        	<ul class="tabs-nav">
                <li class="nav-one"><a href="#popular" class="current"><?php _e('Popular', 'onecommunity-shortcodes'); ?></a></li>
                <li class="nav-two"><a href="#active"><?php _e('Active', 'onecommunity-shortcodes'); ?></a></li>
                <li class="nav-three"><a href="#alphabetical"><?php _e('Alphabetical', 'onecommunity-shortcodes'); ?></a></li>
                <li class="nav-four"><a href="#newest"><?php _e('Newest', 'onecommunity-shortcodes'); ?></a></li>
            </ul>
</div>
</div>

<div class="list-wrap">

<!-- GROUPS LOOP POPULAR -->
<?php if ( bp_has_groups( 'type=popular&per_page=500&max=' . $number_of_groups . '' ) ) : ?>

<ul id="popular">
     <?php while ( bp_groups() ) : bp_the_group(); ?>
<li <?php bp_group_class(); ?>>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<span class="group-box-details-members"><?php bp_group_member_count(); ?></span></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>
 <ul id="popular">
    <div id="message" class="info" style="width:50%">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<!-- POPULAR GROUPS LOOP END -->


<!-- NEWEST GROUPS LOOP START -->
<?php if ( bp_has_groups( 'type=newest&per_page=500&max=' . $number_of_groups . '' ) ) : ?>

<ul id="newest" class="hidden-tab">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li <?php bp_group_class(); ?>>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<span class="group-box-details-members"><?php bp_group_member_count(); ?></span></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>
 <ul id="newest" class="hidden-tab">
    <div id="message" class="info" style="width:50%">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
 </ul>
<?php endif; ?>

<!-- NEWEST GROUPS LOOP END -->


<!-- LAST ACTIVE GROUPS LOOP START -->

<?php if ( bp_has_groups( 'type=active&per_page=500&max=' . $number_of_groups . '' ) ) : ?>

<ul id="active" class="hidden-tab">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li <?php bp_group_class(); ?>>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<span class="group-box-details-members"><?php bp_group_member_count(); ?></span></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>
 <ul id="active" class="hidden-tab">
    <div id="message" class="info" style="width:50%">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
 </ul>
<?php endif; ?>
<!-- LAST ACTIVE GROUPS LOOP END -->



<!-- ALPHABETICAL GROUPS LOOP -->
<?php if ( bp_has_groups( 'type=alphabetical&per_page=500&max=' . $number_of_groups . '' ) ) : ?>

<ul id="alphabetical" class="hidden-tab">
      <?php while ( bp_groups() ) : bp_the_group(); ?>
<li <?php bp_group_class(); ?>>
       <div class="group-box">
	<div class="group-box-image-container">
		<a class="group-box-image" href="<?php bp_group_permalink() ?>forum"><?php bp_group_avatar( 'type=full' ) ?></a>
	</div>
	<div class="group-box-bottom">
	<div class="group-box-title"><a href="<?php bp_group_permalink() ?>forum"><?php $grouptitle = bp_get_group_name(); $getlength = strlen($grouptitle); $thelength = 20; echo mb_substr($grouptitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
	<div class="group-box-details"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?><br />
	<span class="group-box-details-members"><?php bp_group_member_count(); ?></span></div>
	</div>
        </div><!--group-box ends-->
</li>
      <?php endwhile; ?>
</ul>

  <div class="clear"></div>
    <?php do_action( 'bp_after_groups_loop' ) ?>

<?php else: ?>
 <ul id="alphabetical" class="hidden-tab">
    <div id="message" class="info" style="width:50%">
        <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
    </div><br />
</ul>
<?php endif; ?>
<!-- ALPHABETICAL GROUPS LOOP END -->


</div> <!-- List Wrap -->
</div> <!-- tabs-container -->
<div class="clear"></div>
<?php } else { echo "Buddypress plugin is inactive"; }

$shortcode_content = ob_get_clean();
return $shortcode_content;

}

add_shortcode("onecommunity-bp-groups-listing", "onecommunity_bp_groups_listing");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function dd_blog_tiles($atts, $content = null) {

ob_start(); ?>

<div class="blog-tiles">

<div class="blog-tiles-main">
	<?php
	$wp_query = '';
	$paged = '';
	$temp = $wp_query;
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query('posts_per_page=1&paged='.$paged);
	while ($wp_query->have_posts()) : $wp_query->the_post();
	?>

	<div class="box-post-big">

		<div class="blog-tile">

		<?php
		if ( has_post_thumbnail() ) { ?>
			<div class="tile-thumbnail">
			<a href="<?php the_permalink() ?>" title="Fixed link <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('tile-1'); ?>
			</a>
			</div>
		<?php } else { ?>
			<div class="tile-thumbnail">
				<a href="<?php the_permalink() ?>" title="Fixed link <?php the_title_attribute(); ?>">
				<img src="<?php echo esc_url( plugin_basename( __FILE__ ) ) ?>/images/default-blog.jpg" />
				</a>
			</div>
		<?php
		}
		?>

	<div class="blog-cover id<?php echo($wp_query->current_post + 1); ?>"></div>

	<div class="tile-post-title">
	<span><a href="<?php the_permalink() ?>" rel="bookmark" title="Fixed link <?php the_title_attribute(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 80; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span>

	<div class="clear"></div>

	<?php if ( has_category() ) { ?>
	<div class="tile-info">
		<div class="tile-info-category"><?php the_category(', ') ?></div>
	</div>
	<?php } ?>

	</div><!--tile-post-title-->
	<div class="box-v-r-spacer"></div>
	</div>
	</div><!--box-post-big-->

	<?php endwhile; // end of loop ?>
</div><!-- blog-tiles-main -->



<div class="blog-tiles-other">
	<?php
	$wp_query = '';
	$paged = '';
	$temp = $wp_query;
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query('offset=1&posts_per_page=4&paged='.$paged);
	while ($wp_query->have_posts()) : $wp_query->the_post();
	?>

	<div class="box-post-small">

		<div class="blog-tile">

		<?php
		if ( has_post_thumbnail() ) { ?>
			<div class="tile-thumbnail">
			<a href="<?php the_permalink() ?>" title="Fixed link <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('tile-2'); ?>
			</a>
			</div>
		<?php } else { ?>
			<div class="tile-thumbnail">
				<a href="<?php the_permalink() ?>" title="Fixed link <?php the_title_attribute(); ?>">
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() ) ?>/images/default-blog.jpg" />
				</a>
			</div>
		<?php
		}
		?>

	<div class="blog-cover id<?php echo($wp_query->current_post + 1); ?>"></div>

	<div class="tile-post-title">
	<span><a href="<?php the_permalink() ?>" rel="bookmark" title="Fixed link <?php the_title_attribute(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 50; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></span>

	<div class="clear"></div>

	<?php if ( has_category() ) { ?>
	<div class="tile-info">
		<div class="tile-info-category"><?php the_category(', ') ?></div>
	</div>
	<?php } ?>

	</div><!--tile-post-title-->
	<div class="box-v-r-spacer"></div>
	<div class="box-h-b-spacer"></div>
	</div><!--blog-tile-->
	</div><!--box-post-small-->

	<?php endwhile; // end of loop ?>
</div><!-- blog-tiles-other -->

</div><!-- blog-tiles -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("dd-blog-tiles", "dd_blog_tiles");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function my_get_comment_excerpt($comment_ID = 0, $num_words = 15) {
	$comment = get_comment( $comment_ID );
	$comment_text = strip_tags($comment->comment_content);
	$blah = explode(' ', $comment_text);
	if (count($blah) > $num_words) {
		$k = $num_words;
		$use_dotdotdot = 1;
	} else {
		$k = count($blah);
		$use_dotdotdot = 0;
	}
	$excerpt = '';
	for ($i=0; $i<$k; $i++) {
		$excerpt .= $blah[$i] . ' ';
	}
	$excerpt .= ($use_dotdotdot) ? '...' : '';
	return apply_filters('get_comment_excerpt', $excerpt);
}

function onecommunity_recent_blog_comments($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_comments" => '5',
		"col" => '1'
	), $atts));
ob_start();
?>

<div class="recent-comment-container col-<?php echo $col ?>">
<?php
// This is where you run the code and display the output

$args_comm = array( 'number' => $number_of_comments, 'status' => 'approve' );
$comments = get_comments($args_comm);
foreach($comments as $comment) { ?>
	<div class="shordcode-recent-comment">
		<div class="recent-comment-content">
			<?php echo my_get_comment_excerpt($comment->comment_ID, 20); ?>
		</div><!-- shordcode-recent-comment -->

		<div class="recent-comment-bottom">
		<div class="recent-comment-buble"></div>

					<div class="recent-comment-avatar"><?php echo get_avatar($comment->comment_author_email, 30); ?></div>
					<div class="recent-comment-info">
					<?php echo $comment->comment_author; ?> in<br />
					<a href="<?php echo get_comment_link($comment->comment_ID); ?>">
									<?php $post_title = get_the_title($comment->comment_post_ID);
										if(strlen($post_title)>48){
											$post_title = mb_substr($post_title, 0, 40, 'utf-8');
											$post_title = $post_title . '...';
										}
									echo $post_title; ?>
					</a>
					</div><!-- recent-comment-info -->

		</div><!-- recent-comment-bottom -->

	</div><!-- shordcode-recent-comment -->
<?php } ?>
</div><!-- recent-comment-container -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-recent-blog-comments", "onecommunity_recent_blog_comments");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function headline1($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h1">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}

add_shortcode('h1' , 'headline1' );


function headline2($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h2">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h2' , 'headline2' );


function headline3($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h3">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h3' , 'headline3' );


function headline4($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h4">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h4' , 'headline4' );


function headline5($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h5">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h5' , 'headline5' );


function headline6($atts, $content=null, $code="") {
	$return = '<div class="shortcode_h6">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('h6' , 'headline6' );


function my_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'my_one_third');

function my_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_third_last', 'my_one_third_last');

function my_two_third( $atts, $content = null ) {
   return '<div class="two_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'my_two_third');

function my_two_third_last( $atts, $content = null ) {
   return '<div class="two_third last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_third_last', 'my_two_third_last');

function my_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'my_one_half');

function my_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_half_last', 'my_one_half_last');

function my_one_fourth( $atts, $content = null ) {
   return '<div class="one_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'my_one_fourth');

function my_one_fourth_last( $atts, $content = null ) {
   return '<div class="one_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fourth_last', 'my_one_fourth_last');

function my_three_fourth( $atts, $content = null ) {
   return '<div class="three_fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth', 'my_three_fourth');

function my_three_fourth_last( $atts, $content = null ) {
   return '<div class="three_fourth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fourth_last', 'my_three_fourth_last');

function my_one_fifth( $atts, $content = null ) {
   return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fifth', 'my_one_fifth');

function my_one_fifth_last( $atts, $content = null ) {
   return '<div class="one_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_fifth_last', 'my_one_fifth_last');

function my_two_fifth( $atts, $content = null ) {
   return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_fifth', 'my_two_fifth');

function my_two_fifth_last( $atts, $content = null ) {
   return '<div class="two_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('two_fifth_last', 'my_two_fifth_last');

function my_three_fifth( $atts, $content = null ) {
   return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fifth', 'my_three_fifth');

function my_three_fifth_last( $atts, $content = null ) {
   return '<div class="three_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('three_fifth_last', 'my_three_fifth_last');

function my_four_fifth( $atts, $content = null ) {
   return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode('four_fifth', 'my_four_fifth');

function my_four_fifth_last( $atts, $content = null ) {
   return '<div class="four_fifth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('four_fifth_last', 'my_four_fifth_last');

function my_one_sixth( $atts, $content = null ) {
   return '<div class="one_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'my_one_sixth');

function my_one_sixth_last( $atts, $content = null ) {
   return '<div class="one_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('one_sixth_last', 'my_one_sixth_last');

function my_five_sixth( $atts, $content = null ) {
   return '<div class="five_sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode('five_sixth', 'my_five_sixth');

function my_five_sixth_last( $atts, $content = null ) {
   return '<div class="five_sixth last">' . do_shortcode($content) . '</div><div class="clearboth"></div>';
}
add_shortcode('five_sixth_last', 'my_five_sixth_last');




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function onecommunity_blog_posts_tabs($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_posts" => '4'
	), $atts));

ob_start();
?>

<div id="tabs-container2" class="shortcode-posts-tabs-container">
<div id="mytabs2">
<div id="object-nav2">
       <ul class="tabs-nav2">
             <li class="nav-1"><a href="#most-pop" class="current"><?php _e('Most popular', 'onecommunity-shortcodes'); ?></a></li>
             <li class="nav-2"><a href="#most-pop-60"><?php _e('Most popular', 'onecommunity-shortcodes'); ?> (<?php _e('60 days', 'onecommunity-shortcodes'); ?>)</a></li>
             <li class="nav-3"><a href="#latest-posts"><?php _e('Latest posts', 'onecommunity-shortcodes'); ?></a></li>
       </ul>
</div>
</div>


<ul id="most-pop">
<?php
$wp_query = null;
$temp = $wp_query;
$paged = null;
$wp_query = new WP_Query();
$wp_query->query('orderby=comment_count&posts_per_page=' . $number_of_posts . ''.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="blog-thumbs-view-entry">
    <div class="blog-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('my-thumbnail'); ?></a>
	</div>
	<div class="group-box-bottom">
    	<div class="blog-thumb-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 57; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="group-box-details"><?php the_category() ?><br />
		<?php the_time('M j, Y / G:i'); ?></div>
	</div>
	</li>

<?php
endwhile;
wp_reset_query();
?>
</ul>



<ul id="most-pop-60" class="hidden-tab">
<?php

function filter_where($where = '') {
    //posts in the last 60 days
    $where .= " AND post_date > '" . date('Y-m-d', strtotime('-60 days')) . "'";
    return $where;
}

add_filter('posts_where', 'filter_where');

$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('orderby=comment_count&posts_per_page=' . $number_of_posts . ''.'&paged='.$paged);
remove_filter( 'posts_where', 'filter_where' );
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="blog-thumbs-view-entry">
    <div class="blog-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('my-thumbnail'); ?></a>
	</div>
	<div class="group-box-bottom">
    	<div class="blog-thumb-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 57; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="group-box-details"><?php the_category() ?><br />
		<?php the_time('M j, Y / G:i'); ?></div>
	</div>
	</li>

<?php
endwhile;
wp_reset_query();
?>
</ul>



<ul id="latest-posts" class="hidden-tab">
<?php
$temp = $wp_query;
$wp_query = new WP_Query();
$wp_query->query('posts_per_page=' . $number_of_posts . ''.'&paged='.$paged);
while ($wp_query->have_posts()) : $wp_query->the_post();
?>

	<li class="blog-thumbs-view-entry">
    <div class="blog-thumb">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('my-thumbnail'); ?></a>
	</div>
	<div class="group-box-bottom">
    	<div class="blog-thumb-title"><a href="<?php the_permalink(); ?>"><?php $thetitle = get_the_title(); $getlength = strlen($thetitle); $thelength = 57; echo mb_substr($thetitle, 0, $thelength, 'UTF-8'); if ($getlength > $thelength) echo "..."; ?></a></div>
		<div class="group-box-details"><?php the_category() ?><br />
		<?php the_time('M j, Y / G:i'); ?></div>
	</div>
	</li>

<?php
endwhile;
wp_reset_query();
?>
</ul>

<?php $wp_query = null; $wp_query = $temp; ?>

</div> <!-- tabs-container2 -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}
add_shortcode("onecommunity-blog-posts-tabs", "onecommunity_blog_posts_tabs");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function onecommunity_members($atts, $content = null) {
	extract(shortcode_atts(array(
		"number_of_members" => '12',
		"type" => 'popular'
	), $atts));

ob_start();
?>
<div class="shortcode-members">
<?php if ( bp_has_members( 'type=' . $type . '&max=' . $number_of_members . '' ) ) : ?>
			<?php while ( bp_members() ) : bp_the_member(); ?>
				<a href="<?php bp_member_permalink() ?>" class="shortcode-member-item" title="<?php bp_member_name(); ?>"><?php bp_member_avatar('type=thumb&width=60&height=60') ?></a>
			<?php endwhile; ?>
<?php endif; ?>
</div>

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}
add_shortcode("onecommunity-members", "onecommunity_members");





function onecommunity_title( $atts, $content = null ) {
	return '<div class="shortcode-box-title">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'onecommunity-title', 'onecommunity_title' );



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function onecommunity_addthis($atts, $content = null) {

ob_start();
?>

<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_compact"><span class="icon-share">Share</span></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50d5ccc825461c61"></script>
<!-- AddThis Button END -->

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;
}

add_shortcode("onecommunity-addthis", "onecommunity_addthis");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>