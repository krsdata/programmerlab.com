<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>


<section class="error-404 not-found">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center notfoundpage">
				<h1 class="fontbold"><span class="primarycolor">404</span> <?php _e( 'The requested page could not be found', 'biscayalite' ); ?></h1>
				<br>
				<p class="lead">
					<?php _e( 'Please, visit our homepage, try a new search or contact us.', 'biscayalite' ); ?>

				</p>
				<br/>
				<div class="row">
					<div class="col-md-7 col-md-offset-3">
						<form role="search" method="get" id="search" style="float:none;" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" class="col-md-9 search-field" placeholder="<?php echo esc_attr_x( 'Enter search keywords here &hellip;', 'placeholder', 'biscayalite' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'biscayalite' ); ?>">
							<input type="submit" class="col-md-3 search-submit" value="">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
