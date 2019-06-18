<?php
/*
 * Template Name: in_progress
 * description: >-
 * Le template d'un article pas encore fini
 *
 * @package WordPress
 * @subpackage Lagornis_Twenty_Thirteen
 * @since Lagornis_Twenty Thirteen 1.0
 */
 echo "cette page est en cours de redaction, il peux n'y avoir rien, ou des tas de choses mais il manque encore quelque chose pour qu'elle soit enfin visible au grand public :)";


get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'page' );

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
