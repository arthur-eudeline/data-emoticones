<?php 

    require("functions.php");

    $has_emoji = true;
    $is_user = false;
    get_cookie();

    //emoji
    if(isset($_GET["emo-id"])){
        if(intval($_GET["emo-id"]) == 0 || is_nan(intval($_GET["emo-id"])) ){
            die("L'ID saisi n'est pas un nombre");
        }
           
        if(isset($_COOKIE["emojis_visitor"]) && !empty($_COOKIE["emojis_visitor"])){
            $is_user = true;
            if( in_array($_GET["emo-id"] ,$tab_cookie["votes"]) == true ){
                $has_emoji = false;
            } 
        }
        
        $requete='SELECT * FROM emojis WHERE emojis.ID = "'.$_GET["emo-id"].'";'; 
        
    } else {
        if(isset($_COOKIE["emojis_visitor"]) && !empty($_COOKIE["emojis_visitor"])){

            $is_user = true;

            $tab_cookie = json_decode($_COOKIE["emojis_visitor"], true);
            $tab_votes = $tab_cookie["votes"];
            $votes = $tab_votes[0];

            if(count($tab_votes) > 0){
                for($i = 1; $i < count($tab_votes); $i++){
                    $votes = $votes.', '.$tab_votes[$i];
                }
            }

            $requete = 'SELECT * FROM `emojis` WHERE emojis.ID NOT IN ('.$votes.')';

        } else {
            $requete='SELECT * FROM emojis'; 
        }
    }

    if($has_emoji != false){
        $resultats=$connection->query($requete); 
        $ligne=$resultats->fetchAll(PDO::FETCH_OBJ); 
        
        $nb_result = count($ligne);

        if($nb_result > 0){

            for($i=0; $i < $nb_result; $i++){

                $emojis[$i]["ID"] = $ligne[$i]->ID;
                $emojis[$i]["nom"] = $ligne[$i]->nom;
                $emojis[$i]["url"] = $ligne[$i]->url;        

            }

            $rand = rand(0, $nb_result-1);
            $choosen_emoji = $emojis[$rand];

            $has_emoji = true;

        } else{
            $has_emoji = false;
        }  
    } 

    get_header("Voter pour un émoji", rand_color_page().'-template', $pages);

?>
    <div class="jumbotron cover color-changed bg-change">
       <div class="container">
           <div class="row">
               <h1 class="col-xs-12 text-center color-change">Voter pour une émoticône</h1>
           </div>
        </div>
    </div>
    
    <?php if($has_emoji == true){ ?>
    <div class="container container-box emo-box space-bet-lg text-center">
        
        <div class="emo-wrapper">
            <img alt="emoji-<?php echo $choosen_emoji["nom"]; ?>" title="emoji-<?php echo $choosen_emoji["nom"]; ?>" src="<?php echo $choosen_emoji["url"]; ?>" class="img-responsive emo-img">
        </div>
        
    </div>
    <?php } ?>
    
    <div class="container container-box space-bet-lg">
        <?php if($has_emoji == true){ ?>
        <div class="row">
            <h2 class="col-xs-12 col-md-6 col-md-offset-3 text-center">Associez trois mots à cet émoticône</h2>
            <p class="col-xs-12 col-md-6 col-md-offset-3 text-center">Cliquez sur les mots dans la liste ci-dessous pour associer <b>jusqu'à 3 mots</b> à cet émojis.</p>
            <p class="col-xs-12 col-md-6 col-md-offset-3 text-center">Si le mot que vous souhaitez attribuer à l'émoticône <b>ne se trouve pas dans la liste</b>, vous pouvez l'ajouter via le formulaire se trouvant ci-dessous.</p>
        </div>
        
        <div class='row'>
            <hr class="space-bet-md col-xs-12 col-md-6 col-md-offset-3">
        </div>
        
        
        <form id="search-form" class="row space-bet-md">
            <div class="col-md-6 col-md-offset-3">
                <div class="input-group">
                    
                        <input type="text" class="form-control" placeholder="Chercher ou ajouter un mot..." id="search-bar">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="search_imp">Chercher</button>
                            <button class="btn btn-default disabled" type="button" id="add_imp">Ajouter</button>
                        </span>
                        
                </div>
            </div>
        </form>
        
    
        
        <form action="vote-script.php?emo-id=<?php echo $choosen_emoji["ID"] ?>" method="post" class="row visi-form">

            <!--IMPRESSIONS-->
            <div class="col-xs-12" id="buttons">

            </div>
            <!--IMPRESSIONS-->

            <?php if($is_user == false){ ?>
            <!--POPUP DE PAYS D'ORIGINE ET TOUT-->
            <div class="col-md-6 col-md-offset-3 col-xs-12 space-bet-md">
                <div class="row text-center">
                   <div class="col-xs-12">
                        <h2>
                            <span class="little"><i class="material-icons">&#xE853;</i></span>
                            Quelques précisions sur vous :
                        </h2>
                        <p>Ne vous inquiétez pas, tout est anonyme, mais j'ai besoin de quelques renseignements supplémentaires afin d'obtenir de meilleures statiques.</p>
                        <p><b>Ces informations ne vous seront demandé qu'une seule fois</b> aujourd'hui, c'est promis.</p>
                    </div>
                </div>
                
                <div class="row">
                    <hr class="row space-bet-sm">
                </div>
                  
                <ol class="row">
                    <li class="col-xs-12 space-bet-md">
                        <p>Je suis :</p>
                        <label class="col-xs-12" id="female">
                            <input type="radio" name="visi_sexe" value="femme">
                            <div>
                                <span></span>
                                Une femme
                            </div>
                        </label>

                        <label class="col-xs-12" id="male">
                            <input type="radio" name="visi_sexe" value="homme">
                            <div>
                                <span></span>
                                Un homme
                            </div>
                        </label>

                        <label class="col-xs-12" id="no-sexe">
                            <input type="radio" name="visi_sexe" value="none" checked>
                            <div>
                                <span></span>
                                Autre / Secret défense
                            </div>
                        </label>
                    </li>
                
                    <li class="col-xs-12 space-bet-md">
                        
                        <p>Tranche d'âge :</p>
                        <label class="col-xs-12">
                            <select name="age" class="form-control" required>
                                <option disabled selected value="null" >Selectionner mon âge</option>
                                <option value="_16">entre <b>10 et 16 ans</b></option>
                                <option value="17_21">entre <b>17 et 21 ans</b></option>
                                <option value="22_30">entre <b>22 et 30 ans</b></option>
                                <option value="30_39">entre <b>30 et 39 ans</b></option>
                                <option value="40_49">entre <b>40 et 49 ans</b></option>
                                <option value="50_59">entre <b>50 et 59 ans</b></option>
                                <option value="60_">plus de <b>60 ans</b></option>
                            </select>
                        </label>
                    </li>
                </ol>
            </div>
            <!--POPUP D'ORIGINE ET TOUT-->
            <?php } ?>

            <input type="hidden" value="<?php echo $choosen_emoji["ID"] ?>" name="emo-id">
            <input type="hidden" value="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" name="url">
            
            <div class="col-md-6 col-md-offset-3 col-xs-12 text-center space-bet-md">
                <button type="submit" name="submit" class="btn btn-primary big-btn check">Soumettre le vote</button>
            </div>
        </form>
        <?php } else { ?>
            <div class="text-center">
                <h2><span class="big">Désolé !</span></h2>
                
                <div class="space-bet-lg">
                    <p>Vous avez voté pour toutes les émoticônes que nous avions en stock !</p>
                    <p>Merci beaucoup pour votre <b>super participation !</b></p>
                </div>
                
                <a href="<?php echo $pages["emojis-list"]; ?>" title="Retourner à l'accueil" class="btn btn-primary space-bet-md">Retourner à l'accueil</a>
            </div>
        <?php } ?>
</div>

<?php if($has_emoji == true){ ?>    
    <!--Recherche en Ajax-->
    <script type="text/javascript">
        $(document).ready(function(){
            
            var num_res = 1;
            var add_perm = false;
            
            var searchAction = function(e){
                
                var search = $("#search-bar").val().toLowerCase();
                
                $(".button-vote").each(function(){
                    var elem = $(this).find("input");
                    var elem_label = $(this).find("label");
                    var elem_parent = $(this);
                    
//                    if( (elem.attr("id").indexOf(search) == -1) && (!$(elem).is(':checked')) ){
//                    if( (elem.attr("id").indexOf(search) == -1) ){
                    if( (elem_label.text().toLowerCase().indexOf(search) == -1) ){
                        elem_parent.addClass("hidden");
                        elem_parent.removeClass("is-shown");
                    } else {
                        elem_parent.removeClass("hidden");
                        elem_parent.addClass("is-shown");
                    }

                });
                
                num_res = $("#buttons .is-shown").length;
                
                if(num_res <= 5){
                    $("#add_imp").removeClass("disabled");
                    add_perm = true;
                } else {
                    $("#add_imp").addClass("disabled");
                    add_perm = false;
                }
            };
            
            $("#search-bar").blur(function(e){
                searchAction();
            });
            $("#search-bar").on("keypress", function(e){
                searchAction();
            });
            
            var timer;
            $("#search-bar").focusin(function(){
                timer = window.setInterval(function(){searchAction()}, 500);
            });
            
             $("#search-bar").focusout(function(){
                window.clearInterval(timer);
            });
            
            $("#search-form").submit(function(e){
                e.preventDefault();
                searchAction();
            });
            
            $("#add_imp").click(function(e){
                if(add_perm == true){
                    e.preventDefault();
                    $.ajax({
                      method: "POST",
                      url: "add-imp-script-js.php",
                      data: { add_imp : $("#search-bar").val() },
                      dataType: "json",
                    }).done(function(text){
                        if(text[0] == true){
                            $("#buttons").empty();
//                            $("#buttons").load("imp-list.php?slug="+text[1]+"&id="+text[2]+"&text="+text[3]);
                            $("#buttons").load("imp-list.php");
                            
//                            $("#search-form").val("");
                        } else {
                            window.alert(text[1]);
                        }
                    });
                } else {
                    window.alert("Vous ne pouvez pas ajouter d'impression si celle-ci existe déjà. Cherchez d'abord l'impression dans la recherche et, si votre recherche ne donne rien, vous pourrez alors ajouter la votre.")
                }               
            });
            
            $("#buttons").empty();
            $("#buttons").load("imp-list.php");
            
        });
    </script>
    <!--Recherche en Ajax-->
<?php } 

get_footer(true);

?>
