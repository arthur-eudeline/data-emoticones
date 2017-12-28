<?php 
include("configuration/config.php"); 
include("includes/connection.php"); 
include("functions.php");


if(isset($_GET["emo-id"]) && !empty($_GET["emo-id"]) && is_numeric($_GET["emo-id"])){
    //emoji
    $requete='SELECT * FROM emojis WHERE emojis.ID = '.$_GET["emo-id"].';'; 
    $resultats=$connection->query($requete); 
    $ligne=$resultats->fetchAll(PDO::FETCH_OBJ); 
    //fin emoji

    $nb_result = count($ligne);

    for($i=0; $i < $nb_result; $i++){

        $emojis[$i]["ID"] = $ligne[$i]->ID;
        $emojis[$i]["nom"] = $ligne[$i]->nom;
        $emojis[$i]["url"] = $ligne[$i]->url;        

    }

    $rand = rand(0, $nb_result-1);


    //nombre d'impressions par émoji
    $requete='SELECT impression.nom, count(*) as nb FROM `vote`, `impression` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' GROUP BY vote.ID_imp ORDER BY nb desc LIMIT 10';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji

    //nombre d'impressions par émoji et par SEXE = femme
    $requete='SELECT impression.nom, count(*) as nb, visiteur.sexe FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.sexe LIKE "femme" GROUP BY vote.ID_imp ORDER BY nb desc LIMIT 5';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_femmes=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par SEXE = femme

    //nombre d'impressions par émoji et par SEXE = homme
    $requete='SELECT impression.nom, count(*) as nb, visiteur.sexe FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.sexe LIKE "homme" GROUP BY vote.ID_imp ORDER BY nb desc LIMIT 5';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_hommes=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par SEXE = homme

    //nombre d'impressions par émoji et par AGE : _16
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "_16" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["_16"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : _16

    //nombre d'impressions par émoji et par AGE : 17_21
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "17_21" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["17_21"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : 17_21

    //nombre d'impressions par émoji et par AGE : 22_29
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "22_29" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["22_29"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : 22_29

    //nombre d'impressions par émoji et par AGE : 30_39
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "30_39" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["30_39"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : 30_39

    //nombre d'impressions par émoji et par AGE : 40_49
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "40_49" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["40_49"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : 40_49

    //nombre d'impressions par émoji et par AGE : 50_59
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "50_59" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["50_59"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : 50_59

    //nombre d'impressions par émoji et par AGE : 60_
    $requete='SELECT impression.nom, visiteur.age, count(*) as nb FROM `vote`, `impression`, `visiteur` WHERE impression.ID = vote.ID_imp AND vote.ID_emo = '.$_GET["emo-id"].' AND vote.ID_visi = visiteur.ID AND visiteur.age = "60_" GROUP BY impression.nom ORDER BY nb desc LIMIT 3';
    $resultats=$connection->query($requete); 
    $impressions_pour_emoji_age["60_"]=$resultats->fetchAll(PDO::FETCH_OBJ);
    //nombre d'impressions par émoji et par AGE : 60_

    $resultats->closeCursor();

    get_header('Statistiques', rand_color_page().'-template', $pages);
    $count = 0;
    foreach($impressions_pour_emoji_age as $age){
        if(count($age) >= 3){
            $age_unsanitized = str_replace('_', ' et ', $age[0]->age);
            $age_unsanitized = explode('et', $age_unsanitized);

            if($age_unsanitized[0] == ' ' ){
                $age_text = "Moins de".$age_unsanitized[1]."ans";
            } else if($age_unsanitized[1] == ' ' ){
                $age_text = $age_unsanitized[0]."ans et plus";
            } else {
                $age_text = $age_unsanitized[0]."-".$age_unsanitized[1]." ans";
            }

            $votes_age[$count] = array("age" => $age_text, "tab" => $age);
            $count++;
        }
    }

    //    print_r($votes_age);
?>

<div class="jumbotron cover color-changed bg-change">
    <div class="container">
        <div class="row text-center">

            <h1 class="color-change">Statistiques</h1>

        </div>
    </div>
</div>

<div class="container color-changed container-box emo-box space-bet-lg text-center">
    <div class="row">
        <div class="emo-wrapper text-center no-select">
            <img alt="emoji-<?php echo $emojis[$rand]["nom"]; ?>" title="emoji-<?php echo $emojis[0]["nom"]; ?>" src="<?php echo $emojis[0]["url"]; ?>" class="img-responsive emo-img">
            <h2 class="bg-change color-change"><?php echo $emojis[0]["nom"]; ?></h2>
        </div>
    </div>

</div>

<!--MAIN GRAPH-->
<div class="container container-box space-bet-lg resultat-imp-box">
    <div class="row">
        <?php if(count($impressions_pour_emoji) > 9){ ?>          
        <!--GRAPH-->
        <div class="col-xs-12 col-sm-6 col-md-8">
            <h2 class="col-xs-12 text-center">Top 10 des mots les plus associés à l'émoticône</h2>
            <canvas id="chart" class="no-select"></canvas>
        </div>

        <!--LEGEND-->
        <ol class="col-xs-12 col-sm-6 col-md-4 classement">
            <?php $count = 1; ?>
            <?php foreach($impressions_pour_emoji as $imp){ ?>
            <li>
                <span class="no-select"><?php echo $count; ?></span> <b><?php echo $imp->nom; ?></b> : <?php echo $imp->nb; ?>
            </li>
            <?php $count++; } ?>
        </ol>
        <?php } else { ?>

        <div class="col-xs-12 space-bet-lg text-center">
            <h2><b>Aïe !</b></h2>

            <p>
                On dirait bien que trop peu de personnes ont votées pour cette émotîcone pour que les statistiques principales apparaissent !
            </p>

            <?php if(in_array($_GET["emo-id"], $tab_cookie["votes"]) == false){ ?>
            <p>Il semblerait que vous n'ayez pas encore voté pour cette émoticône ! Vous pouvez le faire dès à présent : </p>
            <p><a href="<?php echo $pages["emojis-vote"] ?>?emo-id=<?php echo $_GET["emo-id"] ?>" target="_blank" class="btn btn-primary" title="Voter pour cette émoticône !">Voter pour cette émoticône !</a></p>
            <?php } ?>
        </div>

        <?php } ?>
    </div>
</div>
<!--MAIN GRAPH-->

<!--PAR SEXE-->
<?php if( count($impressions_pour_emoji_femmes) > 4 && count($impressions_pour_emoji_hommes) > 4 ) { ?>
<div class="container">
    <div class="row">
        <div class="row">
            <!--FEMMES-->
            <div class="col-xs-12 col-md-6 space-bet-md">
                <div class="tile-box">
                    <h3 class="text-center">Top 5 : femmes</h3>
                    <canvas id="femmes_chart"></canvas>

                    <!--LEGEND-->
                    <ol class="classement" style="min-height: 275px !important;">
                        <?php $count = 1; ?>
                        <?php foreach($impressions_pour_emoji_femmes as $imp){ ?>
                        <li>
                            <span class="no-select"><?php echo $count; ?></span> <b><?php echo $imp->nom; ?></b> : <?php echo $imp->nb; ?>
                        </li>
                        <?php $count++; } ?>
                    </ol>
                </div>
            </div>
            <!--FEMMES-->

            <!--HOMMES-->
            <div class="col-xs-12 col-md-6 space-bet-md">
                <div class="tile-box">
                    <h3 class="text-center">Top 5 : hommes</h3>
                    <canvas id="hommes_chart"></canvas>

                    <!--LEGEND-->
                    <ol class="classement" style="min-height: 275px !important;">
                        <?php $count = 1; ?>
                        <?php foreach($impressions_pour_emoji_hommes as $imp){ ?>
                        <li>
                            <span class="no-select"><?php echo $count; ?></span> <b><?php echo $imp->nom; ?></b> : <?php echo $imp->nb; ?>
                        </li>
                        <?php $count++; } ?>
                    </ol>
                </div>
            </div>
            <!--HOMMES-->
        </div>
    </div>
</div>
<?php } ?>
<!--PAR SEXE-->

<!--PAR ÂGE-->
<?php if(!empty($votes_age)) { ?>
<div class="container container-box space-bet-lg">
    <h2 class="text-center">Top 3 par tranche d'âge</h2>

    <?php if(count($votes_age) == 1 && count($votes_age) == false){ ?>

    <div class="space-bet-lg">
        <h3 class="text-center"><b><?php echo $votes_age[0]["age"]; ?></b></h3>

        <div class="space-bet-md text-center resultat-min">
            <?php foreach($votes_age[0]["tab"] as $row){ ?>
            <div class="resultat-row">
                <h4><b><?php echo $row->nom; ?></b></h4>
                <p>Voté <?php echo $row->nb; ?> fois</p>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php } else { ?>
    
    <div style="display:none">
        <?php
            echo count($votes_age);
            print_r($votes_age);
            print_r($impressions_pour_emoji_age);
        ?>
    </div>

    <div class="swiper-container space-bet-lg" id="swiper-age">
        <div class="swiper-wrapper">
            <?php for($i = 0; $i < count($votes_age); $i++){ ?>
            <div class="swiper-slide">
                <h3 class="text-center"><b><?php echo $votes_age[$i]["age"]; ?></b></h3>

                <div class="space-bet-md text-center resultat-min">
                    <?php foreach($votes_age[$i]["tab"] as $row){ ?>
                    <div class="resultat-row">
                        <h4><b><?php echo $row->nom; ?></b></h4>
                        <p>Voté <?php echo $row->nb; ?> fois</p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="swiper-button-prev" id="btn-prev"></div>
        <div class="swiper-button-next" id="btn-next"></div>
    </div>

    <div class="space-bet-md text-center" id="swiper-pagination"></div>

    <?php } ?>

</div>
<!--PAR ÂGE-->
<script type="text/javascript" src="js/swiper/swiper.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var swiperAge = new Swiper('#swiper-age', {
            grabCursor : true,

            pagination: {
                el: '#swiper-pagination',
            },

            navigation: {
                nextEl: '#btn-next',
                prevEl: '#btn-prev',
            },

        });
    });
</script>

<?php } ?>

<script src="js/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: [
                <?php foreach($impressions_pour_emoji as $imp){ echo '"'.$imp->nom.'",';} ?>
            ],
            datasets: [{
                label: "My First dataset",
                borderColor: 'rgba(255, 255,255, 1)',
                borderWidth: 5,
                hoverBorderColor: 'rgba(255, 255,255, 1)',
                hoverBorderWidth: 5,
                data: [
                    <?php foreach($impressions_pour_emoji as $imp){ echo $imp->nb.',';} ?>
                ],
                backgroundColor: <?php add_chart_colors(count($impressions_pour_emoji)); ?>,
            }],
        },

        // Configuration options go here
        options: {
            cutoutPercentage:60, 
            tooltips : {
                titleFontFamily : "'Nunito', 'Arial', sans-serif",
                bodyFontSize : 16,
                bodySpacing : 10,
                displayColors : false,
                xPadding : 15,
                yPadding : 10,
            },
            legend : {
                display : false,
            }

        },
    });
</script>

<script>
    var ctx = document.getElementById('femmes_chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: [
                <?php foreach($impressions_pour_emoji_femmes as $imp){ echo '"'.$imp->nom.'",';} ?>
            ],
            datasets: [{
                label: "My First dataset",
                borderColor: 'rgba(255, 255,255, 1)',
                borderWidth: 5,
                hoverBorderColor: 'rgba(255, 255,255, 1)',
                hoverBorderWidth: 5,
                data: [
                    <?php foreach($impressions_pour_emoji_femmes as $imp){ echo $imp->nb.',';} ?>
                ],
                backgroundColor: <?php add_chart_colors(count($impressions_pour_emoji_femmes)); ?>,
            }],
        },

        // Configuration options go here
        options: {
            cutoutPercentage:50, 
            tooltips : {
                titleFontFamily : "'Nunito', 'Arial', sans-serif",
                bodyFontSize : 16,
                bodySpacing : 10,
                displayColors : false,
                xPadding : 15,
                yPadding : 10,
            },
            legend : {
                display : false,
            }
        },
    });
</script>

<script>
    var ctx = document.getElementById('hommes_chart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'doughnut',

        // The data for our dataset
        data: {
            labels: [
                <?php foreach($impressions_pour_emoji_hommes as $imp){ echo '"'.$imp->nom.'",';} ?>
            ],
            datasets: [{
                label: "My First dataset",
                borderColor: 'rgba(255, 255,255, 1)',
                borderWidth: 5,
                hoverBorderColor: 'rgba(255, 255,255, 1)',
                hoverBorderWidth: 5,
                data: [
                    <?php foreach($impressions_pour_emoji_hommes as $imp){ echo $imp->nb.',';} ?>
                ],
                backgroundColor: <?php add_chart_colors(count($impressions_pour_emoji_hommes)); ?>,
            }],
        },

        // Configuration options go here
        options: {
            cutoutPercentage:50, 
            tooltips : {
                titleFontFamily : "'Nunito', 'Arial', sans-serif",
                bodyFontSize : 16,
                bodySpacing : 10,
                displayColors : false,
                xPadding : 15,
                yPadding : 10,
            },
            legend : {
                display : false,
            }
        },
    });
</script>


<?php get_footer(); 

} else {
    header('Location: '.$pages["accueil"]);
    exit;

}

?>