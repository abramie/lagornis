<?php
/**
 * traitement du formulaire de modification d'un compte
 * necessite que tout les $_POST soit definit.
 * Il faut necessairement avoir remplit nom,prenom et statut
 * On recoit en parametre le formulaire de form_modif
 * Pour savoir ce qui est modifié, on recoit en get soit l'id soit le login
 */

require_once ("head.php");



        //on test voir si les champs sont vide ou non sinon on modifie
        if (($_POST['login'] == "" AND $_POST['mdp'] == "")) {
            echo '<script language="javascript">
					  alert("Attention, vous avez oublié de remplir certains champs obligatoire!");
					  history.go(-1);			
					  </script>';
        } else {

            $succes = true;
            $DB_dsn = 'mysql:host='.BDD_host.';dbname='.BDD_base; 	// Data Source Name
            $DB_utilisateur = BDD_user; 							// Nom de l'utilisateur de la base
            $DB_motdepasse = BDD_password; 							// Mot de passe pour accéder à la base
            try
            {
                $bdd = new PDO($DB_dsn,$DB_utilisateur,$DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


                //On recupe les valeurs

            $pseudo = !empty($_POST['login']) ? ($_POST['login']) : $_SESSION['pseudo'];
            $pwd = !empty($_POST['mdp']) ? sha1($_POST['mdp']) : null;

            $bdd->beginTransaction();

            //Partie où on modifie un intervenant
                if(!empty($_POST['login'])){
                    $reqreq = $bdd->prepare("UPDATE comptes_journaux SET pseudo = :pseudo
										WHERE id_compte = :id");
                    $succes = $succes && $reqreq->execute(
                            array(':pseudo' => $pseudo,
                                ':id' => $_SESSION['id']
                            ));

                }
                if(!empty($_POST['mdp'])){
                    $req = $bdd->prepare("UPDATE comptes_journaux SET password = :password
										WHERE id_compte = :id");
                    $succes = $succes && $req->execute(
                            array(':password' => $pwd,
                                ':id' => $_SESSION['id']
                            ));
                }

                if ($succes){
                    echo '<script language="javascript">
                                      alert("Vous avez bien modifié le profil");
                                      window.location.replace("../journaux.php");
                                      </script>';
                    $_SESSION['pseudo'] = $pseudo;
                    $bdd->commit();
                }

                else{
                    $bdd->rollBack();
                    echo '<script language="javascript">
                                  alert("Erreur");
                                  history.go(-1);
                                  </script>';
                }

                //Partie où on modifie un comtpe

            }
            catch(Exception $e)
            {
                die("Erreur connexion à MYSQL : ". $e->getMessage());
            }




    }