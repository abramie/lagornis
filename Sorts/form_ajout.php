<?php

require_once ("include/head.php");

require_once("include/gestion_connexion.php");

//Redirige vers l'ecran de connexion en cas d'acces interdit.
verification_connexion();

?>
<body>
<div class="row haut">
    <div class="clear_float"> </div>

     <?php
    
        $DB_dsn = 'mysql:host='.BDD_host.';dbname='.BDD_base;   // Data Source Name
        $DB_utilisateur = BDD_user;                             // Nom de l'utilisateur de la base
        $DB_motdepasse = BDD_password;                          // Mot de passe pour accéder à la base
        try
        {
            $bdd = new PDO($DB_dsn,$DB_utilisateur,$DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $req = $bdd->prepare('SELECT * FROM Sorts');
            $p = $bdd->prepare('SELECT * FROM Effet_de_sort WHERE Nom_du_sort = :nom');
            
            $rarete = $bdd->prepare('SELECT Rarete FROM Rarete_sort WHERE id = :num');
            $liste_rarete = $bdd->prepare('SELECT * FROM Rarete_sort');
            $succes = $liste_rarete->execute();
            $succes = $req->execute();

            $ecole = $bdd->prepare('SELECT * FROM Ecoles_de_magie, Lien_ecoles_sorts WHERE Lien_ecoles_sorts.ID_sort = :num AND Lien_ecoles_sorts.ID_ecole = Ecoles_de_magie.ID');
            $liste_ecole = $bdd->prepare('SELECT Nom,ID FROM Ecoles_de_magie ORDER BY Nom');
            $succes = $liste_ecole->execute();
            ?>
    <div class="col-md-12 col-sm-12 center">
        <form method="post" action="include/traitement_ajout.php">

            <h2>Ajout de sort</h2>

            <div class="form-group row haut">
                <div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="auteur">Nom du sort
                    <input class="col-sm-2" name="nom_sort" type="text" id="nom_sort"   placeholder="nom du sort"></label>
                </div>
                <div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="nomJ">Description</label>
                    <textarea class="col-sm-2" name="Description" id="De7" placeholder="Description"> </textarea>
                </div>
				
				 <div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="nomJ">Cout</label>
                    <input class="col-sm-2" name="Cout" type="number" id="Cout" placeholder="0">
                </div>
				
				<div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="nomJ">Cout par tour</label>
                    <input class="col-sm-2" name="Cout_tour" type="number" id="Cout_tour"   placeholder="Cout_tour">
                </div>
                
                <div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="nomJ">Concentration
                    <input type="checkbox" name="checkbox_concentration" value="1"></label>
                </div>
                
                 <div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="nomJ">nbActions</label>
                    <input class="col-sm-2" name="nbActions" type="number" id="Cout" placeholder="0" value="1" step="0.5">
                </div>
                
                
                
                
                <!-- Ecoles : -->
                <?php
                   $i =0;
                echo "</br>";
                while($ec = $liste_ecole->fetch()){
                    $name_ecole = $ec['Nom'];
                    ?> <label ><input type="checkbox" name="check_ecol[]" value="<?php echo $ec['ID'];?>" id="ecole"><?php echo $name_ecole;?></label><?php
                    $i++;
                } ?>
                </br>
                <!-- Rarete -->
                 <?php 
                $i =0;
                while( $ra = $liste_rarete->fetch()){
                    $name_rarete =$ra['Rarete'];
                    ?> <label ><input type="radio" name="radio_rare" value="<?php echo $ra['id'];?>" id="rare<?php echo $i;?>"><?php echo $name_rarete;?></label><?php
                    $i++;
                }
                
               
                ?>
                <script>
                    document.getElementById('rare0').checked = true;
                </script>
            </div>
            <!-- puissance -->
            <div id="conteneur">
                
                <div id="element1">
                  <textarea class="col-sm-2" name="puissance[]" id="puissance1" placeholder="puissance 1" maxlength="5000" rows="10" cols="15"> </textarea>
                  <!--<input type="text" value="" id="puissance1" name="puissance[]" />-->
                  <input type="button" value="Supprimer n°1 !" id="delete1" style="none"/>
                </div>
                
            </div> 
            <input type="button" value="Add !" id="add" onclick="ajouterElement()" />
           

            <div class="down-border"></div>
            <div class="row haut">
                <div class="col-lg-6 center">
                    <input class="btn btn-default" type="submit" value="Valider"/>
                
                    
                
                <input type="reset" value="Reset!" onclick=" $(':radio:first').attr('checked', true); ">
                </div>
            </div>
        </form>
    </div>
    
    <?php
        }

        catch (Exception $e)

        {

            die('Erreur : ' . $e->getMessage());

        }


        ?>
</div>
<p><a href="include/deconnexion_session.php"><img style="margin-right:5px;" />Se déconnecter</a></p>
</body>

<script src="http://www.lagornis.monbacasable.fr/sorts/sorts.js"></script>