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
        <div class="text-center">
            <a href="/annonces" class="btn btn-primary">Voir la liste des annonces</a>
        </div>
</body>
</html>