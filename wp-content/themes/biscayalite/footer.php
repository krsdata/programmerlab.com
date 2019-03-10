<?php
/**
 * The template used for displaying Footer
 */
?>
<!-- FOOTER BEGIN
	================================================== -->
	<div class="beforefooter text-center"></div>
	<footer id="colophon" class="site-footer " role="contentinfo">
	<div class="text-center wraptotop">
		<a class="totop"><i class="fa fa-chevron-up"></i></a>
	</div>
		<div class="footer">
			<div class="container">
				<div class="row">
					<?php if ( is_active_sidebar( 'footerwidgets' ) ) : ?>
					<?php dynamic_sidebar( 'footerwidgets' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="footerbottom">
			<div class="container">
				<div class="row">
					<!-- left -->
					<div class="col-md-6">
                     <?php
                      if( get_theme_mod( 'wow_copyright' ) == '') { ?>
                      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> |
                      <a target="_blank" href="<?php echo esc_url( 'https://www.wowthemes.net/themes/biscaya-wp/'); ?>"><?php printf( __( 'Theme by WowThemes.net', 'biscayalite' ), 'WordPress' ); ?></a>
                      <?php }
                      else { echo wp_kses_post( get_theme_mod( 'wow_copyright' ) ); } ?>
                    </div>
					<!-- right -->
					<div class="col-md-6 smallspacetop">
						<div class="pull-right smaller">
						<?php
						if(wp_nav_menu( array( 'theme_location' => 'footer',
												'container'  => false,
												'depth'		 => 0,
												'menu_class' => 'footermenu',
												'fallback_cb' => 'false') ))
						{
						echo wp_nav_menu( array( 'sort_column' => 'menu_order', 'container'  => false, 'theme_location' => 'footer' , 'echo' => '0' ) );
						}
						else
						{

						}
						?>
						</div>
						<div class="clearfix">
						</div>
					</div>
					<!-- end right -->
				</div>
			</div>
		</div>
	</footer>
<!-- FOOTER END
================================================== -->
</div>

<?php wp_footer(); ?>
</body>
</html>