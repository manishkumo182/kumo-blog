<?php
/**
 * Template Name: Submit a Post
 * Lets a logged-in user write a post from the front end. Submissions are
 * saved as "Pending Review" in the dashboard — an editor must approve
 * before it publishes.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$status = isset( $_GET['submitted'] ) ? sanitize_key( $_GET['submitted'] ) : '';
?>

<div class="submit-post-page" id="submit-post">
	<header class="archive-header">
		<h1 class="archive-header__title"><?php the_title(); ?></h1>
		<p class="archive-header__desc"><?php esc_html_e( 'Share your story with our readers — every submission is reviewed before it goes live.', 'kumo-blog' ); ?></p>
	</header>

	<?php if ( ! is_user_logged_in() ) : ?>

		<div class="submit-post-card">
			<p><?php esc_html_e( 'You need an account to submit a post.', 'kumo-blog' ); ?></p>
			<div class="submit-post-auth-actions">
				<a class="btn-contact-submit" href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>"><?php esc_html_e( 'Log In', 'kumo-blog' ); ?></a>
				<a class="btn-contact-submit btn-contact-submit--ghost" href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Create Account', 'kumo-blog' ); ?></a>
			</div>
		</div>

	<?php else : ?>

		<div class="submit-post-card">
			<?php if ( 'success' === $status ) : ?>
				<div class="contact-notice contact-notice--success"><?php esc_html_e( 'Thanks — your post has been submitted and is now pending review.', 'kumo-blog' ); ?></div>
			<?php elseif ( 'error' === $status ) : ?>
				<div class="contact-notice contact-notice--error"><?php esc_html_e( 'Please fill in the title, category and content, then try again.', 'kumo-blog' ); ?></div>
			<?php endif; ?>

			<form class="contact-form submit-post-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
				<input type="hidden" name="action" value="kumo_submit_post" />
				<?php wp_nonce_field( 'kumo_submit_post', 'kumo_submit_post_nonce' ); ?>

				<p class="kumo-hp-field" aria-hidden="true">
					<label for="submit-post-website"><?php esc_html_e( 'Website', 'kumo-blog' ); ?></label>
					<input type="text" id="submit-post-website" name="kumo_hp_website" tabindex="-1" autocomplete="off" />
				</p>

				<div class="form-group">
					<label for="submit-post-title"><?php esc_html_e( 'Title*', 'kumo-blog' ); ?></label>
					<input type="text" id="submit-post-title" name="post_title" required />
				</div>

				<div class="form-group">
					<label for="submit-post-category"><?php esc_html_e( 'Category*', 'kumo-blog' ); ?></label>
					<select id="submit-post-category" name="post_category" required>
						<option value=""><?php esc_html_e( 'Choose a category…', 'kumo-blog' ); ?></option>
						<?php foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) : ?>
							<option value="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label for="submit-post-image"><?php esc_html_e( 'Featured image', 'kumo-blog' ); ?></label>
					<input type="file" id="submit-post-image" name="featured_image" accept="image/*" />
				</div>

				<div class="form-group">
					<label for="submit-post-excerpt"><?php esc_html_e( 'Short summary', 'kumo-blog' ); ?></label>
					<textarea id="submit-post-excerpt" name="post_excerpt" rows="2" placeholder="<?php esc_attr_e( 'One or two sentences that describe the post…', 'kumo-blog' ); ?>"></textarea>
				</div>

				<div class="form-group">
					<label for="submit-post-content"><?php esc_html_e( 'Post content*', 'kumo-blog' ); ?></label>
					<textarea id="submit-post-content" name="post_content" rows="12" required placeholder="<?php esc_attr_e( 'Write your post…', 'kumo-blog' ); ?>"></textarea>
				</div>

				<button type="submit" class="btn-contact-submit"><?php esc_html_e( 'Submit for Review', 'kumo-blog' ); ?></button>
			</form>
		</div>

	<?php endif; ?>
</div>

<?php get_footer(); ?>
