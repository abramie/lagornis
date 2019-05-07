<?php


?>
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link href="styles/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet" style="text/css">
    <link href="styles/bootstrap/font-awesome/css/font-awesome.css" rel="stylesheet">

    <script src="styles/bootstrap/js/popper.js"></script>
    <script src="styles/bootstrap/js/jquery-3.2.1.js"></script>
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>


    <noscript>
        <p id='erreur'>Votre navigateur ne supporte pas Javascript. L'application peut ne pas fonctionner correctement. Contacter votre administrateur.</p>
    </noscript>

</head>
<div class="row haut">
    <div class="clear_float"> </div>

    <div class="col-md-12 col-sm-12 center">
        <form method="post" action="connexion_session.php">

            <h2>Connexion</h2>

            <div class="form-group row haut">
                <div class="col-sm-12">
                    <label class="col-lg-1 col-md-2 col-sm-3" for="login">Login</label> <input class="col-sm-2" name="login" type="text" id="login" placeholder="Enter login">
                </div>
            </div>
            <div class="form-group row haut">
                <div class="col-sm-12 radius">
                    <label class="col-lg-1 col-sm-2" for="pwd">Mdp</label><input class="col-sm-2" name="mdp" type="password" id="mdp" placeholder="Enter password">
                </div>
            </div>
            <?php
            if(isset($_GET['error']) == 1)
            {
                if($_GET['error'] == 1){
                    echo '<div class="alert alert-danger  text-center" role="alert">
											<p>
												<b>Erreur : </b>
												Mauvais identifiant ou mot de passe
											</p>
										</div>';
                }
                if($_GET['error'] == 2){
                    echo '<div class="alert alert-danger  text-center" role="alert">
											<p>
												<b>Erreur : </b>
												Plus de pieces :p
											</p>
										</div>';
                }
            }
            ?>
            <div class="down-border"></div>
            <div class="form-group row haut">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-default">Se connecter</button>
                </div>
            </div>
        </form>
    </div>
    
    <p><a href="connexion_session.php?use_token=test"><img style="margin-right:5px;" />Use coin</a></p>
    </br>
    <p><a href="https://fr.tipeee.com/lagornis"><img style="margin-right:5px;" />Buy coin :p </a></p>
</div>
</html>