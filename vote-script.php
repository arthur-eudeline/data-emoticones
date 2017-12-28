<?php 

include("./configuration/config.php"); 
include("./includes/connection.php"); 
require ('functions.php');

$ID_visi = 0;

if(!empty($_POST)){
    $emo_id = $_POST["emo-id"];

    if(isset($_COOKIE['emojis_visitor']) && !empty($_COOKIE['emojis_visitor'])){ 
        $tab_cookie = json_decode($_COOKIE["emojis_visitor"], true);

        $ID_visi = $tab_cookie["ID"];

        if(isset($tab_cookie["votes"]) && is_array($tab_cookie["votes"]) ){
            array_push($tab_cookie["votes"], $emo_id);
        } else {
            $tab_cookie["votes"] = array( $emo_id );
        }


        $tab_cookie = json_encode($tab_cookie);
        $cookie = setcookie( 'emojis_visitor' , $tab_cookie , time()+60*60*24*30 );


    } else {

        $sexe = $_POST["visi_sexe"];
        $age = $_POST["age"];
        if(!isset($age) || empty($age)){
            die("pas d'âge");
        }

        $values = array(
            "sexe" => $sexe,
            "age"  => $age
        );

        $requete= $connection->prepare("INSERT INTO `visiteur` (`ID`, `sexe`, `age`) VALUES (NULL, :sexe, :age);");
        $requete->execute($values);
        
        $values = array();

        $ID_visi = $connection->lastInsertId();

        $tab_cookie["ID"] =  $ID_visi;
        $tab_cookie["votes"] = array( $emo_id );
        $tab_cookie = json_encode($tab_cookie);
        $cookie = setcookie( 'emojis_visitor' , $tab_cookie , time()+60*60*24*30 );

    } 

    if(isset($_POST["vote-0"])){
        $vote = $_POST["vote-0"];

        $values = array(
            "ID_emo"    => $emo_id,
            "ID_imp"    => $vote,
            "ID_visi"   => $ID_visi
        );
        
        $requete= $connection->prepare("INSERT INTO `vote` (`ID_emo`, `ID_imp`, `ID_visi`) VALUES (:ID_emo, :ID_imp, :ID_visi);");
        $requete->execute($values);
        $vote = '';
        $values = array();
    }
    if(isset($_POST["vote-1"])){
        $vote = $_POST["vote-1"];
        
        $values = array(
            "ID_emo"    => $emo_id,
            "ID_imp"    => $vote,
            "ID_visi"   => $ID_visi
        );


        $requete= $connection->prepare("INSERT INTO `vote` (`ID_emo`, `ID_imp`, `ID_visi`) VALUES (:ID_emo, :ID_imp, :ID_visi);");
        $requete->execute($values);
        $vote = '';
        $values = array();
    }
    if(isset($_POST["vote-2"])){
        $vote = $_POST["vote-2"];
        
        $values = array(
            "ID_emo"    => $emo_id,
            "ID_imp"    => $vote,
            "ID_visi"   => $ID_visi
        );


        $requete= $connection->prepare("INSERT INTO `vote` (`ID_emo`, `ID_imp`, `ID_visi`) VALUES (:ID_emo, :ID_imp, :ID_visi);");
        $requete->execute($values);
        $vote = '';
        $values = array();
    }

    $_POST = array();
}


get_header("Merci de votre participation !", rand_color_page().'-template', $pages);

?>

<div class="jumbotron cover color-changed bg-change">
    <div class="container">
        <div class="row">
            <h1 class="col-xs-12 text-center color-change">
                <span class="big">Merci</span>
                <span class="little">de votre participation !</span>
            </h1>
        </div>
    </div>
</div>

<div class="container container-box space-bet-lg">
    <div class="row text-center">
        <h2 class="col-xs-12">Un grand merci à vous !</h2>
        <div class="col-xs-12 col-md-8 col-md-offset-2">
            <p>Grâce à vous (oui oui <b>vous</b>), je récolte des données qui me sont <b>préciseuses</b> pour mon travail et qui me montre que ce site n'a pas été fait (avec acharnement) pour rien ! Vous êtes tout simplement génial(e).</p>
            <p><b>Alors <strong>merci</strong> beaucoup !</b></p>
        </div>
    </div>

    <hr class="space-bet-md col-xs-12 col-sm-8 col-sm-offset-2">

    <div class="row space-bet-md text-center">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <a href="<?php echo $pages["accueil"]; ?>" title="Retourner à l'accueil" class="btn btn-default">Retourner à l'accueil</a>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4">
            <a href="<?php echo $pages["emojis-vote"]; ?>" title="Voter pour une nouvelle émoticône" class="btn btn-primary">Voter pour une nouvelle émoticône !</a>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-4">
            <a href="<?php echo $pages["emojis-stats"]; ?>?emo-id=<?php echo $_GET["emo-id"]; ?>" title="Voir les statistiques de cette émoticône" class="btn btn-default">Voir les statistiques</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
