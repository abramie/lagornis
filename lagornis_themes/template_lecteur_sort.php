<?php
/*
 * Template Name: lecteur_sort
 * description: >-
  Page d'affichage d'un sort. ?id= pour l'id du sort dans la base de donnée.
 */
/**
 * The template for displaying a spell
 * the id of the spell is given in get ?id
 * 
 * @package WordPress
 * @subpackage Lagornis_Twenty_Thirteen
 * @since Lagornis_Twenty Thirteen 1.0
 */
 //Recupere les variables d'identifiant de la base de donnée.
require_once ("sorts/include/mdp_psw_bdd.php");

$DB_dsn = 'mysql:host='.BDD_host.';dbname='.BDD_base; 	// Data Source Name
$DB_utilisateur = BDD_user; 							// Nom de l'utilisateur de la base
$DB_motdepasse = BDD_password; 							// Mot de passe pour accéder à la base
 

try
{
    //$id = $_GET['id'];
    
    $bdd = new PDO($DB_dsn,$DB_utilisateur,$DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    
    $req = $bdd->prepare('SELECT * FROM Sorts WHERE ID = :id');
	$succes = $req->execute(array(':id' => $_GET['id']));
	
    //if(!$succes)echo "plante";
	$p = $bdd->prepare('SELECT * FROM Effet_de_sort WHERE ID_sort = :id');
			
	$rarete = $bdd->prepare('SELECT Rarete FROM Rarete_sort WHERE id = :num');
    $ecole = $bdd->prepare('SELECT * FROM Ecoles_de_magie, Lien_ecoles_sorts WHERE Lien_ecoles_sorts.ID_sort = :num AND Lien_ecoles_sorts.ID_ecole = Ecoles_de_magie.ID');
	$aspects = $bdd->prepare('SELECT * FROM Aspects WHERE ID_sort = :num');
	
    $donnee = $req->fetch();
    get_header('sorts');
    echo "<title>". get_bloginfo( 'name', 'display' ). ' | '. $donnee['Nom_du_sort'] . "</title>";
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php /* The loop */ ?>
			<?php
			while ( have_posts() ) :
				the_post();
?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>
						<h1 class="entry-title"><?php echo $donnee['Nom_du_sort']; ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<?php //the_content(); 
						
						require_once("sorts/lecteur2.php");
					
						?>
						<?php
						wp_link_pages(
							array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							)
						);
?>
					</div><!-- .entry-content -->
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div><!-- #content -->
        <div class="col-lg-3 center">
        <input class="btn btn-default" type="button" value="Retour" onclick=document.location.href='http://www.lagornis.monbacasable.fr/liste-des-sorts'>
        </div>
	</div><!-- #primary -->
  <?php
}
catch (Exception $e)
{
	
    //die('Erreur : ' . $e->getMessage());
    echo $e->getMessage();
}
 //get_sidebar(); 
get_footer(); ?>