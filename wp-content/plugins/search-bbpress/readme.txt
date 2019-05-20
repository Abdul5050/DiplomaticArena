=== Search bbPress ===
Contributors: Stephen Carroll
Donate link: http://serverpress.com/membership-options
Tags: bbpress, bbPress 2.0, search, forum, forums, topic, topics, reply, replies, custom post type, searching, serverpress
Requires at least: 3.2
Tested up to: 3.2.1
Stable tag: 1.1

This Plugin brings seamless, unified search results from bbPress 2.0 to WordPress and fixes the bbPress login widget in all languages.

== Description ==

Search bbPress extends WordPress' native search to include bbPress post types allowing WordPress to automatically include bbPress content in results. Link adjustments are made to results to ensure users will be taken directly to replies, topics, and forums. This plugin also fixes the double quote typo in bbPress' unified login widget.
 
Simply activate to add the power of search to your forum.

[A plugin from Stephen Carroll at ServerPress.com](http://serverpress.com/)

* Want more? Check out themes, plugins, and everything *Press (WordPress, bbPress, BuddyPress) related at [ServerPress.com](http://serverpress.com/).
* Please support me by checking out my newest projects or visiting [here](http://serverpress.com/membership-options). 

== Installation ==

1. Upload the entire `search-bbpress` folder to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enjoy! ;-)

= How It Works =
* Extends WordPress' native search actions and filters to include bbPress content.
* Hooks into the search results loop to correct bbPress links, to ensure users can be taken to straight to the given forum, topic, or reply.
* Uses jQuery to correct the unified login widget (I've submitted these bugs to core track so hopefully we won't need this in the future).

== Frequently Asked Questions ==

= How can I style search results? =
Inspect the search results and note that h2 headings are proceeded by a div containing the post type (i.e. type-post, type-forum, type-reply, type-topic). You can easily style, omit, enhance, etc. with CSS alone. 


== Changelog ==

= 1.1 =
* Initial release on WordPress.org

== Upgrade Notice ==

= 1.0 =
If you obtained 1.0 outside of WordPress.org, upgrade to get auto-update and reply-to link fixes.

== Additional Info ==
**Purpose:** What good is a forum without search? Our plugin addresses this issue. You may already know that WordPress is an expert on taxonomy and already handles posts, tags, and parent-to-child page hierarchy beautifully. But search is missing on the front end; where it matters to your visitors. My Search bbPress plugin takes care of this and promotes forum participation with links that take them to the heart of their search terms. Have your bbPress implementation deliver search results that matter!
