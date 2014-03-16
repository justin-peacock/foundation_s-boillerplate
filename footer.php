<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Foundation_s
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="row">
			<div class="large-12 columns">
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'foundation-s' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'foundation-s' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'foundation-s' ), 'foundation-s', '<a href="http://byjust.in/" rel="designer">Justin Peacock</a>' ); ?>
				</div><!-- .site-info -->
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
