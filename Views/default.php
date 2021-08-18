<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>titre</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
        <div class="row" id="posi2">
            <div id="posi02">
               <a href=""><div  id="posi3">Mes annonces</div></a> 
               
                <a href="/"><div  id="posi3">Accueil</div></a>
                <a href="/annonces"><div  id="posi3">Liste des annonces</div></a>

                <?php if(isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
                
                <a href="/users/profil"><div  id="posi3">Profil</div></a>
                <a href="/users/logout"><div  id="posi3">Deconnexion</div></a>

                <?php else: ?>
                 <a href="/users/login"><div  id="posi3">Connexion</div></a>

                 <?php endif; ?>
            </div> 
        </div>
        
        <div class="container">
        <?php if(!empty($_SESSION['erreur'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['erreur']; unset($_SESSION['erreur']); ?>
            </div>
            <?php endif; ?>
            <?php if(!empty($_SESSION['message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['message']; unset($_SESSION['message']) ;?>
                    </div>
            <?php endif; ?>
            <?= $contenu ?>
        </div>
</body>
</html>