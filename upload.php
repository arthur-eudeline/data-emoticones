
<?php
    $target_dir = "uploads/emojis/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    $sub_emoticone = false;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "svg" && $imageFileType != "svg+xml") {
            $check=false;
            die("oui");
        }else{
            $check=true;
        }

        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                
                //écriture de l'URL
                $url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $url = explode("/", $url);
                $url_comp = '';
                for($i=0; $i < count($url)-1; $i++){
                    $url_comp = $url_comp.$url[$i]."/";
                }

                $url = "http://".$url_comp.$target_file;
                $sub_emoticone = true;
                
                include("./configuration/config.php"); 
                include("./includes/connection.php"); 
                
                    $requete="INSERT INTO `emojis` (`ID`, `nom`, `url`) VALUES (NULL, '".$_POST["emo_nom"]."', '".$url."');"; 
                    $resultats=$connection->query($requete);  
                    $resultats->closeCursor(); 

                
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }


    }



?>