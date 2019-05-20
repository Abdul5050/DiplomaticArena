<?php

/**
 * Search Loop
 *
 * @package bbPress
 * @subpackage Theme
*/

?>

<?php do_action( 'bbp_template_before_search_results_loop' ); ?>

<div class="clear"></div>
<div style="color:#ffffff; background:#ff0000; padding:6px; margin:10px 0;">If you bought 1 theme then you can browse 1 forum only.
If system is asking you for the License Code again then it means you are trying to enter protected forum from search results page.</div>
<div class="clear"></div>

<ul id="bbp-search-results" class="forums bbp-search-results">

	<li class="bbp-header">

		<div class="bbp-search-author"><?php  _e( 'Author',  'bbpress' ); ?></div><!-- .bbp-reply-author -->

		<div class="bbp-search-content">

			<?php _e( 'Search Results', 'bbpress' ); ?>

		</div><!-- .bbp-search-content -->

	</li><!-- .bbp-header -->

	<li class="bbp-body">

		<?php while ( bbp_search_results() ) : bbp_the_search_result(); ?>

			<?php bbp_get_template_part( 'loop', 'search-' . get_post_type() ); ?>

		<?php endwhile; ?>

	</li><!-- .bbp-body -->

	<li class="bbp-footer">

		<div class="bbp-search-author"><?php  _e( 'Author',  'bbpress' ); ?></div>

		<div class="bbp-search-content">

			<?php _e( 'Search Results', 'bbpress' ); ?>

		</div><!-- .bbp-search-content -->

	</li><!-- .bbp-footer -->

</ul><!-- #bbp-search-results -->

<?php do_action( 'bbp_template_after_search_results_loop' ); ?>