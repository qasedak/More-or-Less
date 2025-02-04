<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<?php
	$dark = '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/dark.css"><meta name="theme-color" content="#0d0d0d">';
	$light = '<meta name="theme-color" content="#D0D0D0FF">';
	$static_color = get_theme_mod( 'dark_mod' );
	$color_scheme = $_COOKIE["color_scheme"] ?? false;
	if ($static_color == "auto" || empty($static_color)) {
		if ($color_scheme == "dark") {
			echo $dark;
		} else {
			echo $light;
		}
	} else if ($static_color == "dark") {
		echo $dark;
	} else {
		echo $light;
	}
	?>

	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />

	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if (function_exists('wp_body_open')) {
		wp_body_open();
	} else {
		do_action('wp_body_open');
	}
	?>


	<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start header
	/*-----------------------------------------------------------------------------------*/
	?>

	<header id="masthead" class="site-header" role="banner">
		<div class="container">

			<div class="gravatar">
				<?php
				if (has_custom_logo()) {
					the_custom_logo();
				} else {
					// grab admin email and their photo
					$admin_email = get_option('admin_email');
					echo get_avatar($admin_email, 100);
				}
				?>
			</div>
			<!--/ author -->

			<div id="brand">
				<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php echo esc_attr(get_bloginfo('name')); ?></a> &mdash; <span><?php echo esc_attr(get_bloginfo('description')); ?></span></h1>
			</div><!-- /brand -->

			<nav role="navigation" class="site-navigation main-navigation">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
			</nav><!-- .site-navigation .main-navigation -->

			<div class="clear"></div>
		</div>
		<!--/container -->

	</header><!-- #masthead .site-header -->

	<div class="container">

		<div id="primary">
			<div id="content" role="main">


				<?php
				/*-----------------------------------------------------------------------------------*/
				/* Start Home loop
	            /*-----------------------------------------------------------------------------------*/

				if (is_home() || is_archive()) {

				?>
					<?php if (have_posts()) : ?>

						<?php while (have_posts()) : the_post(); ?>

							<article class="post">

								<h1 class="title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_title() ?>
									</a>
								</h1>
								<div class="post-meta">
									<?php
									// If comments are open or we have at least one comment, load up the comment template.
									if (comments_open() || get_comments_number()) :
										comments_template();
									endif;
									?>

								</div>
								<!--/post-meta -->

								<div class="the-content">
									<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
										<?php the_content(__('Continue...', 'less-reimagined')); ?>

										<?php wp_link_pages(); ?>
									</div>
								</div><!-- the-content -->

								<div class="meta clearfix">
									<div class="category"><?php the_category(); ?></div>
									<div class="tags"><?php the_tags('| &nbsp;', '&nbsp;'); ?></div>
								</div><!-- Meta -->

							</article>

						<?php endwhile; ?>

						<!-- pagintation -->
						<div id="pagination" class="clearfix">
							<div class="past-page"><?php previous_posts_link(__('Newer &raquo;', 'less-reimagined')); ?></div>
							<div class="next-page"><?php next_posts_link(__(' &laquo; Older', 'less-reimagined')); ?></div>
						</div><!-- pagination -->


					<?php else : ?>

						<article class="post error">
							<h1 class="404"><?php esc_html_e('Nothing posted yet', 'less-reimagined'); ?></h1>
						</article>

					<?php endif; ?>


				<?php } //end is_home(); 
				?>

				<?php
				/*-----------------------------------------------------------------------------------*/
				/* Start Single loop
	            /*-----------------------------------------------------------------------------------*/

				if (is_single()) {
				?>


					<?php if (have_posts()) : ?>

						<?php while (have_posts()) : the_post(); ?>

							<article class="post">

								<h1 class="title"><?php the_title() ?></h1>
								<div class="post-meta">
									<?php if (comments_open()) : ?>
										<span class="comments-link">
											<?php comments_popup_link(__('Comment', 'less-reimagined'), __('1 Comment', 'less-reimagined'), __('% Comments', 'less-reimagined')); ?>
										</span>
									<?php endif; ?>

								</div>
								<!--/post-meta -->

								<div class="the-content">
									<?php the_content(__('Continue...', 'less-reimagined')); ?>

									<?php wp_link_pages(); ?>
								</div><!-- the-content -->

								<div class="meta clearfix">
									<div class="category"><?php the_category(); ?></div>
									<div class="tags"><?php the_tags('| &nbsp;', '&nbsp;'); ?></div>
								</div><!-- Meta -->

							</article>

						<?php endwhile; ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template
						if (comments_open() || '0' != get_comments_number()) {
							comments_template('', true);
						}
						?>


					<?php else : ?>

						<article class="post error">
							<h1 class="404"><?php esc_html_e('Nothing posted yet', 'less-reimagined'); ?></h1>
						</article>

					<?php endif; ?>


				<?php } //end is_single(); 
				?>

				<?php
				/*-----------------------------------------------------------------------------------*/
				/* Start Page loop
	/*-----------------------------------------------------------------------------------*/

				if (is_page()) {
				?>

					<?php if (have_posts()) : ?>

						<?php while (have_posts()) : the_post(); ?>

							<article class="post">

								<h1 class="title"><?php the_title() ?></h1>

								<div class="the-content">
									<?php the_content(); ?>

									<?php wp_link_pages(); ?>
								</div><!-- the-content -->

							</article>

						<?php endwhile; ?>

					<?php else : ?>

						<article class="post error">
							<h1 class="404"><?php esc_html_e('Nothing posted yet', 'less-reimagined'); ?></h1>
						</article>

					<?php endif; ?>

				<?php } // end is_page(); 
				?>


				<?php
				/*-----------------------------------------------------------------------------------*/
				/* Start 404 Page
	            /*-----------------------------------------------------------------------------------*/

				if (is_404()) {
				?>
					<article class="post error">
						<h1 class="404"><?php esc_html_e('Nothing posted yet', 'less-reimagined'); ?></h1>
					</article>
				<?php } // end is_404(); 
				?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

	</div><!-- / container-->

	<?php
	/*-----------------------------------------------------------------------------------*/
	/* Start Footer
	/*-----------------------------------------------------------------------------------*/
	?>

	<footer class="site-footer" role="contentinfo">
		<div class="site-info container">
			<a href="https://wordpress.org/" title="<?php esc_html_e('A Semantic Personal Publishing Platform', 'less-reimagined'); ?>" rel="generator"><?php esc_html_e('Proudly powered by WordPress', 'less-reimagined'); ?></a>
			<span class="sep"> <?php esc_html_e('and', 'less-reimagined'); ?> </span>
			<?php esc_html_e('Less Reimagined by Mohammad Anbarestany', 'less-reimagined'); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->

	<?php wp_footer(); ?>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie/dist/js.cookie.min.js"></script>
	<script>
		// code to set the `color_scheme` cookie
		const $color_scheme = Cookies.get("color_scheme");

		function get_color_scheme() {
			return (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) ? "dark" : "light";
		}

		function update_color_scheme() {
			Cookies.set("color_scheme", get_color_scheme());
		}
		// read & compare cookie `color-scheme`
		if ((typeof $color_scheme === "undefined") || (get_color_scheme() !== $color_scheme))
			update_color_scheme();
		// detect changes and change the cookie
		if (window.matchMedia)
			window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", update_color_scheme);
		// get clinet's time
		if (!$color_scheme) {
			let uTime = new Date();
			if (uTime.getHours() >= 18 || uTime.getHours() <= 5) {
				document.cookie = "cScheme=false; SameSite=Lax; path=/";
			}
		} else {
			document.cookie = "cScheme=true; SameSite=Lax; path=/";
		}
		function getCookie(name) {
			const value = `; ${document.cookie}`;
			const parts = value.split(`; ${name}=`);
			if (parts.length === 2) return parts.pop().split(';').shift();
		}
		<?php if ($static_color == "auto") { ?>

		if (getCookie("cScheme") == "false") {
			var head = document.getElementsByTagName('HEAD')[0];
			var link = document.createElement('link');
			link.rel = 'stylesheet';
			link.type = 'text/css';
			link.href = '<?php echo get_template_directory_uri(); ?>/dark.css';
			head.appendChild(link);
		}
		
		<?php } ?>
	</script>
</body>

</html>