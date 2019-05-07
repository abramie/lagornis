<?php

require_once ("include/head.php");
require_once ("include/gestion_connexion.php");
?>
<body>
<div id="primary" class="row haut">
    <main id="main" class="site-main" role="main">
        <?php
    
        $DB_dsn = 'mysql:host='.BDD_host.';dbname='.BDD_base;   // Data Source Name
        $DB_utilisateur = BDD_user;                             // Nom de l'utilisateur de la base
        $DB_motdepasse = BDD_password;                          // Mot de passe pour accéder à la base
        try
        {
            $bdd = new PDO($DB_dsn,$DB_utilisateur,$DB_motdepasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $req = $bdd->prepare('SELECT * FROM Sorts ORDER BY Nom_du_sort');
            $p = $bdd->prepare('SELECT * FROM Effet_de_sort WHERE Nom_du_sort = :nom');
            
            $rarete = $bdd->prepare('SELECT Rarete FROM Rarete_sort WHERE id = :num');
            $liste_rarete = $bdd->prepare('SELECT Rarete FROM Rarete_sort');
            $succes = $liste_rarete->execute();
            $succes = $req->execute();

            $ecole = $bdd->prepare('SELECT * FROM Ecoles_de_magie, Lien_ecoles_sorts WHERE Lien_ecoles_sorts.ID_sort = :num AND Lien_ecoles_sorts.ID_ecole = Ecoles_de_magie.ID');
            $liste_ecole = $bdd->prepare('SELECT Nom FROM Ecoles_de_magie ORDER BY Nom');
            $succes = $liste_ecole->execute();
            ?>
        <input type="text" id="search_texte" class="test" onkeyup="changement()">   
          <div id="controle_filtrage" >
         
          </div>
          <div id="checkbox_rarete">
          <?php 
                $i =0;
                while($name_rarete = $liste_rarete->fetch()['Rarete']){
                    
                    ?> <label ><input type="checkbox" checked name="check_rare<?php echo $i;?>" value="<?php echo $name_rarete;?>" id="rare" onchange="changement()"><?php echo $name_rarete;?></label><?php
                    $i++;
                }
          ?>
        </div>
        <div id="checkbox_ecole">
            <a onclick="decocher()" >Tout decocher. </a>
             / 
            <a onclick="cocher()" >Tout cocher. </a>
        <?php 
            $i =0;
            echo "</br>";
            
            while($name_ecole = $liste_ecole->fetch()['Nom']){
                
                ?> <label ><input type="checkbox" checked name="check_ecol<?php echo $i;?>" value="<?php echo $name_ecole;?>" id="ecole" onchange="changement()"><?php echo $name_ecole;?></label><?php
                $i++;
            }
        ?>     
        </div>
        <div id="list_sorts" class="table-responsive" style="width:100%">
            <table class="table table-hover" id="table_sort" >
                <thead>
                    <tr>
                    <th>Nom du sort</th>
                    <th>Description</th>
                    <th>Ecole du sort</th>
                    <th>Rareté</th>
                    <th>Nombres d'actions</th>
                    </tr>
                </thead>
                <tbody>   
                <?php
                
                while($donnee = $req->fetch())
                {
                    //echo "<tr class='line_color' onclick='window.open(\"http://www.lagornis.monbacasable.fr/sorts/lecteur.php?id=".$donnee['ID']."\")'>";
                    echo "<tr class='line_color' onclick='window.open(\"http://www.lagornis.monbacasable.fr/lecteur?id=".$donnee['ID']."\")'>";
                        ?>
                            <td><?php echo $donnee['Nom_du_sort']; ?></td>
                            <td><?php echo explode(".",$donnee['Description'])[0] . "."; ?></td>
                            <td><?php
                                $succes = $ecole->execute(array(':num' => $donnee['ID'])); 
                                ?><ul style="list-style-type:none"><?php
                                while($nom_ecole = $ecole->fetch()['Nom']){
                                    echo "<li>";
                                    echo $nom_ecole;
                                    echo "</li>";
                                } 
                                                        
                                ?></ul> </td>
                                    
                            <td><?php $rarete->execute(array(':num' => $donnee['rarete']) ); 
                                    
                                    echo $rarete->fetch()['Rarete'];?>
                            </td>
                             <td><?php echo $donnee['nbActions']; ?></td>
                         </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
            <?php
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());

        }
        ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->
</body>
<script src="http://www.lagornis.monbacasable.fr/sorts/sorts.js"></script>
<?php// get_footer(); ?>