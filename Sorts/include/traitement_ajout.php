<?php
require_once ("head.php");
require_once ("gestion_connexion.php");
//ini_set('display_errors',1);
if ($_POST['nom_sort'] == "" OR $_POST['Description'] == "" ) {
    echo '<script language="javascript">
					  alert("Attention, vous avez oublié de remplir certains champs obligatoire!");
					  history.go(-1);			
					  </script>';
} else {
    var_dump($_POST);
    $succes = true;
    $DB_dsn = 'mysql:host=' . BDD_host . ';dbname=' . BDD_base;    // Data Source Name
    $DB_utilisateur = BDD_user;                            // Nom de l'utilisateur de la base
    $DB_motdepasse = BDD_password;                            // Mot de passe pour accéder à la base
    try {
        $bdd = new PDO($DB_dsn, $DB_utilisateur, $DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

        //On recupe les valeurs
    
        $nom_sort = $_POST['nom_sort'];
        $Description = $_POST['Description'];
        $Cout = $_POST['Cout'];
		$Cout_tour = $_POST['Cout_tour'];
		$Ecole = $_POST['Ecole_magie'];
		$Type = $_POST['Type_magie'];
		
        if(isset($_POST['checkbox_concentration'])){
            $concentration = 1;
        } else $concentration =0 ;
		
		
        $bdd->beginTransaction();

        //Partie où on modifie un intervenant

        $rarete = $_POST[radio_rare];

        $req = $bdd->prepare("INSERT INTO Sorts(Nom_du_sort,Description,Cout,Cout_par_tour,Concentration,rarete, nbActions,author)
                                            VALUES(:nom_sort, :Description, :Cout, :Cout_tour, :Concentration, :rarete, :action, :author)");
                                            
        $succes =  $succes &&$req->execute(
               array(':nom_sort' => $nom_sort,
					':Description' => $Description,
                    ':Cout' => $Cout,
					':Cout_tour' => $Cout_tour,
					':Concentration' => $concentration,
                    ':rarete' => $rarete,
                    ':action' => $_POST['nbActions'],
                    ':author' => $_SESSION['pseudo']
                ));
        /** Id du sort ajouté */
        $id_sort = $bdd->lastInsertId();  


        /***Gestion des ecoles **/
        $add_ecole = $bdd->prepare("INSERT INTO Lien_ecoles_sorts(ID_sort,ID_ecole) VALUES(:id_sort, :id_ecole) ");
        echo $id_sort;
        if(!empty($_POST['check_ecol'])){
            foreach($_POST['check_ecol'] as $ecole){
                $succes = $succes && $add_ecole->execute(
                    array(':id_sort' => $id_sort,
                        ':id_ecole' => $ecole));
            }
        }
       
       /***Gestion des puissances **/
        $add_puissance = $bdd->prepare("INSERT INTO Effet_de_sort(ID_sort,Puissance, Description) VALUES(:id_sort, :pui, :descr) ");
        if(!empty($_POST['puissance'])){
            $i=0;
            foreach($_POST['puissance'] as $p){
                if($p == "")continue;
                $i++;
                $succes = $succes && $add_puissance->execute(
                    array(':id_sort' => $id_sort,
                        ':pui' => $i,
                        ':descr' => $p));
                       
            }
        }
               
        
      
        if ($succes) {
            echo '<script language="javascript">
                                      alert("Votre contribution a été prise en compte");
                                      history.go(-1);
                                      </script>';

            $bdd->commit();
            if(isset($_SESSION['coin'])){
                use_token();
            }
           
        } else {
           
            $bdd->rollBack();
            echo '<script language="javascript">
                                  alert("Erreur");
                                  history.go(-1);
                                  </script>';
        }

        //Partie où on modifie un comtpe

    } catch (Exception $e) {
        die("Erreur connexion à MYSQL : " . $e->getMessage());
    }
}

?>