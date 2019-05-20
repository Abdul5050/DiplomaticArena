<?php
/*
Plugin Name: Search bbPress 2.0
Plugin URI: http://www.serverpress.com/products/search-bbpress
Description: Adds bbPress 2.0 to WordPress search results with links back to the forum, topic, and replies.
Version: 1.0
Author: Stephen Carroll
Author URI: http://www.steveorevo.com
License: OpenSource under GPL2
*/

/*

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

// Create our main bbPress Search object
global $bbpsearch;
$bbpsearch = new bbPressSearch();

// Define our main Content Filter class
class bbPressSearch {
    
    // Store the forum url for search results
    public $forum_url ="";
    public $prior_url = "";
    
    // Hook into the WordPres Shortcode API in our constructor
    function __construct(){
        
        // Add bbPress to WordPress search results
        add_filter( 'bbp_get_theme_compat_templates', array(&$this, 'bbp_get_theme_compat_templates') );
        add_filter( 'bbp_register_forum_post_type', array(&$this, 'bbp_register_search') );
        add_filter( 'bbp_register_topic_post_type', array(&$this, 'bbp_register_search') );
        add_filter( 'bbp_register_reply_post_type', array(&$this, 'bbp_register_search') );
        
        // Optimized - only when searching...
        if ( isset($_GET['s']) ) {
            
            // Filter search results to proper forum/topic/reply
            add_filter( 'the_permalink', array(&$this, 'the_permalink') );
            add_filter( 'the_excerpt', array(&$this, 'the_excerpt') );
        }
        
        // Patch the login button via jQuery
        add_action( 'wp_head', array(&$this, 'wp_head') );
        wp_enqueue_script( 'jquery');
    }
    function wp_head(){
        
        // Patch Log In typo        
        echo '<script type="text/javascript">
                (function($){
                    $(function(){
                        $(".widget form.bbp-login-form button#user-submit").each(function(){
                            $(this).html($(this).html().toString().replace(String.fromCharCode(34),""));
                        });
                    });
                })(jQuery);
              </script>';
    }
    function the_excerpt($content){
        
        // Change empty 'Continue reading' link to the given forum
        if ($this->forum_url != "") {
            $content = str_replace('<a href="">', '<a href="' . $this->forum_url . '">', $content);
            $content = str_replace($this->prior_url, $this->forum_url, $content);
        }
        return $content;
    }
    function the_permalink($post_link){
        
        // Remap forum replies' permalink to proper reply url (forum topic#post)
        global $post;
        $this->forum_url = "";
        if ($post->post_type == 'reply') {
            $this->prior_url = $post_link;
            $post_link = bbp_get_reply_url($post->ID);
            $this->forum_url = bbp_get_reply_url($post->ID);

            // Omit 'reply' link that maps to incorrect post template
            $post->comment_status = "closed";
        }elseif ($post->post_type == 'topic') {
            $this->forum_url = $post_link;            
        }elseif ($post->post_type == 'forum'){
            $this->forum_url = bbp_get_reply_url($post->ID);
        }
        return $post_link;
    }
    function bbp_get_theme_compat_templates($templates){
        
        // Tell bbPress to favor your template's native search.php when looking at results
        if ( isset($_GET['s']) ) {
            array_unshift($templates, 'search.php');
        }
        return $templates;
    }
    function bbp_register_search($post_type){
        
        // Include bbPress in search results
        $post_type['exclude_from_search'] = false;
        return $post_type;
    }
}
?>
