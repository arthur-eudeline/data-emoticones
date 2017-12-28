<?php 

    $auth = false;

    if( isset($_POST["auth"]) ){
        
        $mdp = md5($_POST["mdp"]);
        
        //U******6
        if($_POST["login"] == "areudeline" && $mdp = "3952a5b9adb8765241a0ffb8e6ca9f57"){
            $auth = true;
        } else{
            $auth = false;
        }
        
    }

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Emojis</title>
    <meta charset="utf-8">
</head>

<body>
    
    <h1>Uploader un émoji :</h1>
    
    <?php if(!isset($_POST["auth"]) || $auth == false){ ?>
        <h2>S'identifier</h2>
        <form method="post">
            <div>
                <label for="login">Login :</label>
                <input type="text" name="login" id="login" placeholder="Login...">
            </div>
            
            <div>
                <label for="mdp">Mot de passe :</label>
                <input type="password" name="mdp" id="mdp" placeholder="Mot de passe...">
            </div>
            
            <div>
                <button type="submit" name="auth" value="connexion">Connexion</button>
            </div>
        </form>
    <?php } ?>

     <?php if($auth == true){ ?>
        <h2>Choisir un fichier :</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="text" name="emo_nom" placeholder="Nom de l'émoticone..." required>
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <input type="submit" value="Upload Image" name="submit">
        </form>
    <?php } ?>
    
</body>
    

</html>