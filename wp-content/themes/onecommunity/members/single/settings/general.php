<?php

/**
 * BuddyPress Member Settings
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

get_header( 'buddypress' ); ?>

	<div id="content">

			<?php do_action( 'bp_before_member_settings_template' ); ?>

			<div id="item-header">

				<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>

			</div><!-- #item-header -->

			<div id="item-body" role="main">

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
					<ul>

						<?php bp_get_displayed_user_nav(); ?>

						<?php do_action( 'bp_member_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->

				<?php do_action( 'bp_before_member_body' ); ?>

				<div class="item-list-tabs no-ajax" id="subnav">
					<ul>

						<?php bp_get_options_nav(); ?>

						<?php do_action( 'bp_member_plugin_options_nav' ); ?>

					</ul>
				</div><!-- .item-list-tabs -->
<div id="item-body-padding">

				<?php do_action( 'bp_template_content' ); ?>

<?php do_action( 'bp_before_member_settings_template' ); ?>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

	<?php if ( !is_super_admin() ) : ?>

		<label for="pwd"><?php _e( 'Current Password <span>(required to update email or change current password)</span>', 'buddypress' ); ?></label>
		<input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small" <?php bp_form_field_attributes( 'password' ); ?>/> &nbsp;<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Password Lost and Found', 'buddypress' ); ?>"><?php _e( 'Lost your password?', 'buddypress' ); ?></a>

	<?php endif; ?>

	<label for="email"><?php _e( 'Account Email', 'buddypress' ); ?></label>
	<input type="email" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" <?php bp_form_field_attributes( 'email' ); ?>/>

	<label for="pass1"><?php _e( 'Change Password <span>(leave blank for no change)</span>', 'buddypress' ); ?></label>
	<input type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small password-entry" <?php bp_form_field_attributes( 'password' ); ?>/> &nbsp;<?php _e( 'New Password', 'buddypress' ); ?><br />
	<div id="pass-strength-result"></div>
	<label for="pass2" class="bp-screen-reader-text"><?php _e( 'Repeat New Password', 'buddypress' ); ?></label>
	<input type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/> &nbsp;<?php _e( 'Repeat New Password', 'buddypress' ); ?>

	<?php do_action( 'bp_core_general_settings_before_submit' ); ?>

	<div class="submit">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Save Changes', 'buddypress' ); ?>" id="submit" class="auto" />
	</div>

	<?php do_action( 'bp_core_general_settings_after_submit' ); ?>

	<?php wp_nonce_field( 'bp_settings_general' ); ?>

</form>

<?php do_action( 'bp_after_member_settings_template' ); ?>

				<?php do_action( 'bp_after_member_body' ); ?>
</div>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_settings_template' ); ?>

	</div><!-- #content -->

<?php get_sidebar( 'buddypress' ); ?>

<?php get_footer( 'buddypress' ); ?>
