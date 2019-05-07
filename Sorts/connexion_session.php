
test

<?php
require_once ("include/gestion_connexion.php");

if($_GET['use_token'] != ""){
    use_token();
}else{
    connexion($_POST['mdp'],$_POST['login']);
}


?>
