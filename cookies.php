<?php 

include("configuration/config.php"); 
include("includes/connection.php");
require("functions.php");

get_header("L'utilisation des cookies", rand_color_page().'-template', $pages); 

?>

<div class="jumbotron cover color-changed bg-change">
    <div class="container">
        <div class="row">
            <h1 class="col-xs-12 text-center color-change">Utilisation des Cookies</h1>
        </div>
    </div>
</div>

<div class="container space-bet-lg header-box container-box">
    <div class="row text-center">
        <h2 class="col-xs-12">À propos de l'utilisation des Cookies</h2>

        <div class="text-left">
            <p class="col-xs-12">
                Tout d'abord, les cookies <b>ne sont pas</b> utilisées à des fins commercialies ou publicitaires.
            </p>

            <p class="col-xs-12">
                Ils servent à une tâche simple mais néanmoins essentielle au bon fonctionnement du site : vous empêcher de voter plusieurs fois pour une même émoticône.
            </p>

            <p class="col-xs-12">
                Les Cookies sont en effet utilisés pour stoquer les identifiants des émoticônes pour lesquelles vous avez voté. Ainsi, le site ne vous proposera pas de vous faire voter une seconde fois pour cette émoticône et ce, dans le but de ne pas fausser les statistiques. 
            </p>

            <p class="col-xs-12">
                En résumé, ne vous inquiétez pas, les cookies utilisés pour le site sont très légers et ne comportent aucune information sensible sur votre personne. Pour preuve, le contenu des cookies du site (si vous avez déjà voté pour une émoticône) est disponnible en bas de page ! 
            </p>
        </div>

    </div>
</div>

<div class="container space-bet-lg container-box">
    <div class="row text-center">
        <h2 class="col-xs-12">Comment sont utilisés les Cookies ?</h2>

        <div class="text-left">
            <p class="col-xs-12">
                C'est très simple : les cookies utilisés stoquent deux choses.
            </p>
            
            <ul>
                <li>
                    Votre <b>identifiant</b> :
                    Même s'il est vrai que tous les votes sont <b>totalement anonymisés</b>, le besoin de savoir que vous revenez sur le site n'en reste pas moins important. Ainsi, il est nécessaire de stoquer votre "<em>identité</em>" sous forme de numéro attribué tout simplement en fonction du du nombre de visiteurs avant vous.
                </li>
                
                <li>
                    Les <b>votes que vous avez effectués</b> :
                    Il faut également stoquer les identifiants des émoticônes pour lesquelles vous avez voté. Celles-ci sont également stoquées sous forme de numéro et servent tout simplement à être "<em>mises de côté</em>" lorsque vous naviguez sur le site, afin qu'elles ne vous soient pas proposées pour un vote.
                </li>
            </ul>
            
            <p class="col-xs-12">Les cookies sont donc simplement utilisés pour que les émoticônes qui vous sont proposées ne soient que celles pour lesquelles vous n'avez pas encore votées !</p>
            
            <p class="col-xs-12">Des cookies de Google peuvent également apparaîtres, par exemple "_ga" ou "_gid" et sont liés à l'utilisation de <a href="https://www.google.com/analytics/">Google Analytics</a>, qui me permet de suivre le trafic du site. </p>

            <?php if(!empty($_COOKIE)){ ?>
            <p class="col-xs-12 cookie-content">
                <b>Code source :</b>
                <code>
                print_r($_COOKIE);
                <pre>
                <?php print_r($_COOKIE); ?>
                </pre>
                </code>
            </p>
            <?php } else { ?>
            <p class="col-xs-12">
                <b>Désolé, mais étant donné que vous n'avez pas encore effectué de vote sur le site, aucun cookie n'est enregistré sur votre appareil.</b>
            </p>
            <?php } ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>