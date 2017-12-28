<?php 
require('functions.php');


if(isset($_POST["add_imp"])){

    $text = sanitize($_POST["add_imp"], true);

    include("configuration/config.php"); 
    include("includes/connection.php"); 
    
    //Effectuer une recherche d'impressions pour voir si elle existe déjà par son SLUG
    $requete='SELECT impression.slug FROM `impression` where impression.slug = "'.$text["text"].'"';
    $resultats=$connection->query($requete); 
    $recherche_impressions_existantes =$resultats->fetchAll(PDO::FETCH_OBJ);
    //Effectuer une recherche d'impressions pour voir si elle existe déjà par son SLUG
    
    //si cette impression n'existe pas déjà on l'ajoute
    if(empty($recherche_impressions_existantes)){
        //impressions
        
        $values = array(
            "no_sani"   => $text["no-sani"],
            "text"  => $text["text"],
        );
            
        $requete= $connection->prepare('INSERT INTO `impression` ( `nom`, `slug`) VALUES ( :no_sani, :text);'); 
        $requete->execute($values);
        
        $requete='SELECT impression.slug, impression.ID as ID FROM `impression` where impression.slug = "'.$text["text"].'"';
        $resultats=$connection->query($requete); 
        $ID =$resultats->fetchAll(PDO::FETCH_OBJ);

        foreach($ID as $row){
            $ID = $row->ID;
        }

        
        $resultats->closeCursor();
        
        $reponse[0] = true;
        $reponse[1] = $text["text"];
        $reponse[2] = $ID;
        $reponse[3] = $text["no-sani"];
        $reponse = json_encode($reponse, JSON_UNESCAPED_UNICODE);
        echo $reponse;
        return $reponse;
    } else {
        $reponse[0] = false;
        $reponse[1] = "Désolé, cette impression est déjà saisie dans la base. Vous ne pouvez pas ajouter deux fois la même expression.";
        $reponse = json_encode($reponse, JSON_UNESCAPED_UNICODE);
        echo $reponse;
    }
}

?>