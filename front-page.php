<?php
/**
 * The template file to show the front page display.
 *
 * @package ThemeGrill
 * @subpackage Radiate
 * @since Radiate 1.0
 */

get_header(); ?>

	<?php
	$page_array = array( get_theme_mod( 'page-setting-one' ), get_theme_mod( 'page-setting-two' ), get_theme_mod( 'page-setting-three' ) );
	$get_featured_pages = new WP_Query( array(
				'posts_per_page' 			=> 3,
				'post_type'					=> array( 'page' ),
				'post__in'		 			=> $page_array,
				'orderby' 		 			=> 'post__in',
				'ignore_sticky_posts' 	=> 1 					
			));
	?>
	<div id="featured_pages" class="clearfix">
		<?php
		$j = 1;
		while ( $get_featured_pages->have_posts() ) : 
			$get_featured_pages->the_post();
			if( $j % 2 == 1 && $j > 1 ) { $page_class = "tg-one-third tg-one-third-last"; }	
			else { $page_class = "tg-one-third"; }				
			?>
			<div class="<?php echo $page_class; ?>">				
				<div class="page_text_container">
					<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
					<h1 class="entry-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<?php the_excerpt(); ?><a class="more-link" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php _e( 'Read more','radiate' ); ?></a>
				</div>					
			</div>
			<?php $j++;
		endwhile; 
		wp_reset_postdata();
		?>
	</div>
	<div class="banner-content1">
		
			<div class="banner">
				<?php dynamic_sidebar('banner-section');
				?>
			</div>
		</div>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php radiate_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>
		
		</main><!-- #main -->
		
	</div><!-- #primary -->
	<div class="banner-content">
		<div class="widget-bar">
			<div class="widget-1">
				<?php dynamic_sidebar('page-widget');
				?>
			</div>
		</div>
	
		<div class="widget1">
			<div class="widget-2">
				<?php dynamic_sidebar('page-widget-1');
				?>
			</div>
		</div>
		<div class="widget2">
			<div class="widget-3">
				<?php dynamic_sidebar('page-widget-2');
				?>
			</div>
		</div>
		</div> <!--/.banner-content -->


<?php get_footer(); ?>
