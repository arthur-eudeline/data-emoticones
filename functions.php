<?php
include("configuration/config.php"); 
include("includes/connection.php"); 

$GLOBALS["connection"] = $connection;

$GLOBALS["pages"] = array(
    "accueil" => 'emo-list.php',
    "emojis-list" => 'emo-list.php',
    "emojis-vote" => 'index.php',
    "emojis-stats" => 'stats.php',
    "projet"    => 'projet.php'
);

function get_cookie(){
    global $tab_cookie;
    if(isset($_COOKIE["emojis_visitor"]) && !empty($_COOKIE["emojis_visitor"])){
        $tab_cookie = json_decode($_COOKIE["emojis_visitor"], true);
    } else {
        $tab_cookie["ID"] = "";
        $tab_cookie["votes"] = array();
    }

    return $tab_cookie;
}

get_cookie();

function add_chart_colors($nb_colors){

    $colors = array(
        '#addbff'
    );

    $count=0;
    echo "[";
    for($i=0 ; $i < $nb_colors-1 ; $i++){
        echo '"'.$colors[$count].'",';
        $count++;
        if($count == count($colors)){
            $count = 0;
        }
    }

    echo "'".$colors[$count]."']";

}

function rand_color_page(){
    $colors= array( 'blue', 'green', 'red', 'orange' );

    return $colors[rand( 0, count($colors)-1 )];
}

function sanitize($text = '', $no_sani = false){

    //enlever les .
    $text = str_replace ('.', ' ', $text);

    //enlever les <
    $text = str_replace ('<', ' ', $text);

    //enlever les >
    $text = str_replace ('>', ' ', $text);

    //enlever les ?
    $text = str_replace ('?', ' ', $text);

    //enlever les ,
    $text = str_replace (',', ' ', $text);

    //enlever les ;
    $text = str_replace (';', ' ', $text);

    $text_no_sani = $text;

    //enlever les !
    $text = str_replace ('!', ' ', $text);

    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);


    if (empty($text)) {
        $text = 'n-a';
    }

    if($no_sani == true){
        $tab = array(
            "text" => $text,
            "no-sani" => $text_no_sani
        );
    } else {
        $tab = $text;
    }

    return $tab;

}

function get_nb_votes($connection = ''){
    $requete='SELECT COUNT(*) as nb FROM vote'; 
    $resultats=$connection->query($requete); 
    $nb_votes=$resultats->fetchAll(PDO::FETCH_OBJ); 
    $nb_votes=$nb_votes[0]->nb;
    $resultats->closeCursor();

    return $nb_votes;        
}

function get_header($title = "Data emojis", $color = '', $pages_array = ''){
    $pages = $pages_array;
?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <link rel="icon" href="favicon.ico"/>
        <link rel="icon" type="image/png" href="favicon.png" />

        <!--FACEBOOK-->
        <meta property="og:url"                content="http://emoticones-data.tp.mmi-lepuy.fr/" />
        <meta property="og:type"               content="website" />
        <meta property="og:title"              content="Voter pour une émoticône" />
        <meta property="og:description"        content="En quelques cliques, donnez votre avis et soutenez un projet étudiant !" />
        <meta property="og:image"              content="http://emoticones-data.tp.mmi-lepuy.fr/cover.jpg" />

        <link href="css/swiper/swiper.css" rel="stylesheet">
        <link rel="stylesheet" href='css/bootstrap/bootstrap.min.css'>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/fonts.css">

        <script type="text/javascript" src="js/jquery.min.js"></script>
    </head>

    <body class="<?php echo $color; ?>">

        <nav class="container-fluid">
            <div class="row">
                <div class="col-xs-8 col-sm-2">
                    <div class="fb-share-button" data-href="http://emoticones-data.tp.mmi-lepuy.fr" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Femoticones-data.tp.mmi-lepuy.fr%2F&amp;src=sdkpreparse">Partager</a></div>
                </div>

                <div class="col-xs-4 text-right hide-desktop">
                    <button type="button" class=" menu-trigg" id="menu-trigg"></button>
                </div>

                <div class="col-sm-10 menu-wrapper" id="menu-wrapper">
                    <div class="row">
                        <div class="col-xs-12 col-sm-8">
                            <ul class="row">
                                <li class="default"><a href="<?php echo $pages["accueil"]; ?>">Accueil</a></li>
                                <li class="sep no-select"></li>
                                <li class="default"><a href="index.php">Voter<span class="hide-desktop"> pour une émoticône</span></a></li>
                                <li class="sep no-select"></li>
                                <li class="default"><a href="<?php echo $pages["projet"]; ?>">Le projet</a></li>
                            </ul>
                        </div>

                        <div class="col-sm-4 col-xs-12 text-right">
                            <?php if(get_nb_votes($GLOBALS["connection"]) > 50){ ?>
                            <div class="vote-count color-changed no-select color-change-border more-dark ">
                                <span class="color-change-text">Déjà <b><?php echo get_nb_votes($GLOBALS["connection"]); ?></b> votes !</span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
        </nav>  


        <?php
}

function get_footer($footer_bottom = false){

        ?>

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.11&appId=394086584359249';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111336964-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-111336964-1');
        </script>


        <script>
            $(document).ready(function(){
                $("#menu-trigg").on("touch click", function(){
                    $(this).toggleClass("is-open");
                    $("#menu-wrapper").toggleClass("is-open");
                });
            });
        </script>

        <?php if(empty($_COOKIE["emojis_visitor"])){ ?>
        <script>
            $(document).ready(function(){
                $("#cookie_close").on("touch click", function(){
                    $("#cookies").attr("style", "display:none");
                });
            });
        </script>
        <div class="cookie container-fluid" id="cookies">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-xs-12">
                            Ce site utilise des cookies à des fins purement statistiques et les données utilisées sont anonymisées. En poursuivant ma navigation, je certifie être en accord avec l'utilisation des dits cookies.
                        </div>

                        <div class="col-md-2 col-xs-12 text-center">
                            <span id="cookie_close">fermer</span>
                            <a class="btn-primary btn" href="cookies.php">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        
        <?php     //return false; ?>

        <footer class="<?php if($footer_bottom == true){ echo "bottom"; } ?>">
            <div class="container">
                <p class="col-xs-12 col-md-8">Toutes les émoticônes présentes sur le site ont été créées par <a href="https://www.flaticon.com/authors/freepik">Freepik</a>, proviennent de <a href="https://www.flaticon.com/">Flaticon</a> et son disponnible <a href="https://www.flaticon.com/packs/emoji">ici</a>.</p>

                <p class="col-xs-12 col-md-4 text-right">
                    Ce site a été créé par <a href="http://arthur-eudeline.fr" target="_blank" rel="author">Arthur EUDELINE</a>.<br>
                    <a href="cookies.php">Comment et pourquoi les cookies sont utilisés sur ce site</a>
                </p>
            </div>



        </footer>
    </body>
</html>
<?php
}
?>