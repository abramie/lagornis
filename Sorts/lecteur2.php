<?php
/**
 * Created by PhpStorm.
 * User: jerem
 * Date: 26/06/18
 * Time: 22:54
 */
 //ini_set('display_errors',1);
?>

<?php echo $donnee['Description']; ?>
</br>
<?php echo "Cout :" ;echo $donnee['Cout']; ?>
<?php 
if($donnee['Cout_par_tour'] != 0){
    echo "</br>";
    echo "Cout par tour : ";
    echo $donnee['Cout_par_tour'];
    echo "</br>";
    } ?>

<?php if($donnee['Concentration'] != 0)
            echo "Concentration";?>
</br>
<?php echo "Nombres d'actions :" ;echo $donnee['nbActions']; ?>

<?php $rarete->execute(array(':num' => $donnee['rarete']) ); 
        
        echo $rarete->fetch()['Rarete'];
?>
    <ul style="list-style-type:none">
    <?php
    
    
    $succes = $ecole->execute(array(':num' => $donnee['ID'])); 
    while($nom_ecole = $ecole->fetch()['Nom']){
        echo "<li>";
        echo $nom_ecole;
        echo "</li>";
    } 
                            
    ?></ul>
</br>

    
<?php $succes = $p->execute(array(':id' => $donnee['ID'])); 

    while($puissance = $p->fetch() )
    {
        ?>
        
        <ul style="list-style-type: circle;">
            <li>
                <?php echo 'p' ;echo $puissance['Puissance'];?> 
                <?php echo $puissance['Description']; ?> 
            </li>
        </ul>
        <?php
    }
    
    $succes = $aspects->execute(array( ':num' => $donnee['ID']));
    
    if($aspects->rowCount() !=0 ){
?>

<h5>Aspects du sorts : </h6>
<?php 

//Zone d'affichage des aspects


while($asp = $aspects->fetch()['ID_aspect'])
{
    
    ?>
    
    <table class="table table-hover">
    <thead>
    <tr>
    <th>Nom du sort</th>
    <th>Description</th>
    <th>Ecole du sort</th>
    </tr>

    </thead>
    <tbody>


    <?php
    $asp_descript = $bdd->prepare('SELECT * FROM Sorts WHERE ID = :id');
    $asp_descript->execute(array( ':id' => $asp));
    while($donnee_aspect = $asp_descript->fetch())
    {
        
        
        echo "<tr class='line_color' onclick='window.open(\"http://www.lagornis.monbacasable.fr/lecteur?id=".$donnee_aspect['ID']."\")'>";
       
        ?>
       
        <td><?php echo $donnee_aspect['Nom du sort']; ?></td>
        <td><?php echo $donnee_aspect['Description']; ?></td>
        <td><?php
        $succes = $ecole->execute(array(':num' => $donnee_aspect['ID'])); 
        ?><ul style="list-style-type:none"><?php
        while($nom_ecole = $ecole->fetch()['Nom']){
            echo "<li>";
            echo $nom_ecole;
            echo "</li>";
        } 
                                
        ?></ul>	</td>							
        </tr>
        <?php
    }
        ?>
    </tbody>
    </table>		
                    
    
    
    
<?php
}
    }
?>
    
    
    
    

	
						
						
						
 



