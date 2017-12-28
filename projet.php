<?php 

include("configuration/config.php"); 
include("includes/connection.php");
require("functions.php");

get_header("En savoir plus sur le projet", rand_color_page().'-template', $pages); 

?>

<div class="jumbotron cover color-changed bg-change">
    <div class="container">
        <div class="row">
            <h1 class="col-xs-12 text-center color-change">À propos du projet</h1>
        </div>
    </div>
</div>

<div class="container space-bet-lg header-box container-box">
    <div class="row text-center">
        <h2 class="col-xs-12">Le projet</h2>

        <div class="text-left">
            <p class="col-xs-12">
                Ce site s'inscrit dans le but de recueillir de la data, pour ensuite la ressortir visuellement sous forme de graphiques.
            </p>

            <p class="col-xs-12">
                Le projet est né pour répondre à un sujet de datavisualiation conduit par un enseignant de l'Institut Universitaire de Technologie (IUT) du Puy-en-Velay (43), rattaché à l'Université Clermont-Auvergne.
            </p>

            <p class="col-xs-12">
                Ainsi pour répondre à l'énoncé du sujet, que nous pourrions simplement réduire à "mettre en forme des données", l'idée d'analyser les réactions que suscitent les émoticônes m'est venue à l'esprit après mettre rendu compte que, dans certains cas, les mots que l'on associe à ces dernières peuvent varier selon les personnes. 
            </p>

            <p class="col-xs-12">
                De ce fait, mon but est simple : savoir ce à quoi vous font penser quelques émoticônes. 
            </p>
        </div>

        <p class="col-xs-12">               
            <a href="<?php echo $pages["emojis-vote"]; ?>" class="btn btn-primary">
                Voter pour un émoji aléatoire
            </a>
        </p>
    </div>
</div>

<div class="container space-bet-lg container-box">
    <div class="row text-center">
        <h2 class="col-xs-12">Mes sources</h2>

        <div class="text-left">
            <p class="col-xs-12">
                Toutes les émoticônes utilisées sur ce site ont été téléchargées sur <a href="https://www.flaticon.com/">Flaticon</a>.
            </p>

            <p class="col-xs-12">
                Elles ont été créées par <a href="https://www.flaticon.com/">Flaticon</a> et sont disponnibles juste ici : <a href="https://www.flaticon.com/packs/emoji">lien vers les émoticônes</a>.
            </p>
        </div>

    </div>
</div>

<?php get_footer(); ?>