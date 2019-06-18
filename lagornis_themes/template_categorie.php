<?php
/*
 * Template Name: categorie
 * description: >-
 * Le template d'un article listant une categorie
 *
 * @package WordPress
 * @subpackage Lagornis_Twenty_Thirteen
 * @since Lagornis_Twenty Thirteen 1.0
 */
 

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'content_categorie', 'page' );
                
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
