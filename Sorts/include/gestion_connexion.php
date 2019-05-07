<?php
/**
 * Created by PhpStorm.
 * User: jerem
 * Date: 07/05/18
 * Time: 14:21
 */

require_once('mdp_psw_bdd.php');
session_start();

/**Connexion
 * Fonction qui verifie que les identifiants
 * de connexion sont valide et genere la session de connexion
 * @param $mdp : le mot de passe
 * @param $login
 */
function connexion($mdp,$login){

    //Récupération du mot de passe et de l'identifiant tapé par l'utilisateur
    //Hachage du mot de passe
    $DB_dsn = 'mysql:host='.BDD_host.';dbname='.BDD_base; 	// Data Source Name
    $DB_utilisateur = BDD_user; 							// Nom de l'utilisateur de la base
    $DB_motdepasse = BDD_password; 							// Mot de passe pour accéder à la base
    try
    {
        $bdd = new PDO($DB_dsn,$DB_utilisateur,$DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


        $pass_hache = sha1($mdp);


        // Vérification des identifiants
        $req = $bdd->prepare('SELECT *
                                FROM comptes_journaux
                                WHERE pseudo = :login AND password = :mdp');
        $req->execute(array(
            ':login' => $login,
            ':mdp' => $pass_hache));
        $resultat = $req->fetch();


        //Si les identifiants ne correspondent pas on redirige vers la même page
        if (!$resultat)
        {
            echo "header";
            header("Location: http://".$_SERVER['HTTP_HOST']. site_path . "/form_connexion.php?error=1");
        }
        //Sinon on démarre la session
        else
        {
            session_start();

            $_SESSION['id'] = $resultat['id_compte'];
            $_SESSION['pseudo'] = $login;

            if (isset($_SESSION['id']))
            {
                header("Location: http://".$_SERVER['HTTP_HOST']. site_path . "/form_ajout.php");
            }else{
                echo "erreur ";
            }
        }
    }
    catch(Exception $e)
    {
        die("Erreur connexion à MYSQL : ". $e->getMessage());
        echo "test";
    }

}


function use_token(){
      
    $DB_dsn = 'mysql:host='.BDD_host.';dbname='.BDD_base; 	// Data Source Name
    $DB_utilisateur = BDD_user; 							// Nom de l'utilisateur de la base
    $DB_motdepasse = BDD_password; 							// Mot de passe pour accéder à la base
    try
    {
        $bdd = new PDO($DB_dsn,$DB_utilisateur,$DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


        


        // Vérification des identifiants
        $req = $bdd->prepare('SELECT *
                                FROM token
                                WHERE nom = :login');
        $req->execute(array(
            ':login' => "simon"
            ));
        $resultat = $req->fetch()['nombre'];
        
        
        //Si les identifiants ne correspondent pas on redirige vers la même page
        if ($resultat <= 0)
        {
            echo "header";
            header("Location: http://".$_SERVER['HTTP_HOST']. site_path . "/form_connexion.php?error=2");
        }
        //Sinon on démarre la session
        else
        {
            $eat = $bdd->prepare('UPDATE token SET nombre = :newval WHERE nom = :login');
            $eat->execute(array(
            ':newval' => $resultat-1,
            ':login' => "simon"
            ));
            session_start();

            $_SESSION['id'] = 0;
            $_SESSION['pseudo'] = "invité";
            $_SESSION['coin'] = $resultat-1;
            if (isset($_SESSION['id']))
            {
                header("Location: http://".$_SERVER['HTTP_HOST']. site_path . "/form_ajout.php");
            }else{
                echo "erreur ";
            }
        }
    }
    catch(Exception $e)
    {
        die("Erreur connexion à MYSQL : ". $e->getMessage());
        echo "test";
    }
}


/**Deconnexion
 *Fonction qui supprime la session de connexion
 */
function deconnexion(){

    // Suppression des variables de session et de la session
    $_SESSION = array();
    session_destroy();
    header("Location: http://".$_SERVER['HTTP_HOST']. site_path . "/form_connexion.php" );
}

/**
 *
 *
 */
function verification_connexion(){

    if(!isset($_SESSION['id'])) //Dans le cas ou on est pas log, on retourne sur la page de co
    {
        echo $_SERVER['HTTP_HOST'];
        header("Location: http://".$_SERVER['HTTP_HOST']. site_path . "/form_connexion.php");
        exit;
    }
    
    if(isset($_SESSION['coin'])){
        echo "Bonjour invité. Il vous reste : " . $_SESSION['coin']+1 . "pieces à utilisé";
    }

}