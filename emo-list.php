<?php 

include("configuration/config.php"); 
include("includes/connection.php");
require("functions.php");

get_header("Liste des émoticônes", rand_color_page().'-template', $pages); 

$requete='SELECT * FROM emojis order by rand()'; 
$resultats=$connection->query($requete); 
$liste_emojis=$resultats->fetchAll(PDO::FETCH_OBJ); 

?>
<div class="jumbotron color-changed bg-change" id="home-cover">
    <h1 class="col-xs-12 text-center color-change no-select">émoticônes</h1>
</div>

<div class="container space-bet-lg header-box container-box">
    <div class="row text-center">
        <h2 class="col-xs-12">Le projet</h2>
        
        <p class="col-xs-12">
            Ce site s'inscrit dans un projet étudiant de l'IUT du Puy-en-Velay 43, visant à récolter de la data. En votant simplement pour quelques émoticônes, vous m'aiderez dans mon projet. Pour en savoir un (tout petit peu) plus, <a href="projet.php">c'est par ici !</a>
        </p>

        <p class="col-xs-12">               
            <a href="<?php echo $pages["emojis-vote"]; ?>" class="btn btn-primary">
                Voter pour un émoji aléatoire
            </a>
        </p>
    </div>
</div>


<!--EMOJIS LISTE DEBUT-->
<div class="container">
    <div class="row">
       <div class="row">
        <?php foreach($liste_emojis as $emoji){ ?>
        <?php if( in_array($emoji->ID, $tab_cookie["votes"] ) == true ){ ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 is-voted space-bet-md">
            <div class="tile-box">
                <img class="img-responsive" src="<?php echo $emoji->url; ?>" >

                <hr class="space-bet-md">

                <p class="text-center">
                    <span class="btn btn-primary disabled">Vous avez déjà voté</span>
                </p>

                <p class="text-center">
                    <a href="<?php echo $pages["emojis-stats"] ?>?emo-id=<?php echo $emoji->ID; ?>" class="btn btn-default">Voir les statistiques</a>
                </p>
            </div>                    
        </div>
        <?php } else {  ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 space-bet-md">
            <div class="tile-box">
                <img class="img-responsive" src="<?php echo $emoji->url; ?>" >
                <hr class="space-bet-md">

                <p class="text-center">
                    <a href="<?php echo $pages["emojis-vote"] ?>?emo-id=<?php echo $emoji->ID; ?>" class="btn btn-primary">Donner mon avis</a>
                </p>

                <p class="text-center">
                    <a href="<?php echo $pages["emojis-stats"] ?>?emo-id=<?php echo $emoji->ID; ?>" class="btn btn-default">Voir les statistiques</a>
                </p>
            </div>
        </div>
        <?php }} ?>
        </div>
    </div>
</div>
<!--EMOJIS LISTE FIN-->

<?php get_footer(); ?>