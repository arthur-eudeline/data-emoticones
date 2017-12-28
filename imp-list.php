<?php 
    include("configuration/config.php"); 
    include("includes/connection.php"); 

    //impressions
    $requete='SELECT * FROM impression ORDER BY nom'; 
    $resultats=$connection->query($requete);
    $ligne=$resultats->fetchAll(PDO::FETCH_OBJ); 
    $resultats->closeCursor();

    $tab_impressions = $ligne;

    echo "<div class='text-center buttons-wrapper'>";

    foreach($tab_impressions as $imp){ 
        if(!empty($_GET) && isset($_GET["slug"]) && $imp->slug == $_GET["slug"]){
            $checked = "checked";
        } else {
            $checked = '';
        }

?>

    <div class="button-vote">
        <input type="checkbox" value="<?php echo $imp->slug; ?>" id="<?php echo $imp->slug; ?>" data-impID="<?php echo $imp->ID; ?>" <?php echo $checked; ?>>
        <label for="<?php echo $imp->slug; ?>" data-impSlug="<?php echo $imp->slug; ?>" class="no-select <?php echo $checked; ?>"><?php echo $imp->nom; ?></label>
    </div>


<?php } ?>
</div>
        <hr class="space-bet-md col-xs-12 col-md-6 col-md-offset-3">
          
        <div class="row">
            <h2 class="col-xs-12 text-center">Mots choisis :</h2>
            <div class="col-xs-12 col-md-10 col-md-offset-1" id="zone">

            </div>
        </div>
           
        <hr class="space-bet-md col-xs-12 col-md-6 col-md-offset-3">


<!--Ajout des bulles de votes-->
    <script type="text/javascript">
        $(document).ready(function(){
            
            var count_vote = 0;
            var vote = new Array();
            
            $("#buttons label").on("touch click", function(e){
                var nom = $(this).text();
                var $target = $(this).parent().find("input");
                if(count_vote == 3 && !$target.is(":checked")){
                    $target.prop("checked", true);
                    return ;
                }
                
                //ajout de la bulle
                if(!$target.is(":checked") && count_vote < 3){
                    
                    var impID = $target.attr("data-impID");
                    
                    $("#zone").append("<div class='"+impID+" vote col-xs-12 col-md-4 no-select' data-impID='"+impID+"'><span>"+nom+"<input type='hidden' name='vote-"+count_vote+"' value='"+impID+"'></span></div>");
                    
                    vote[count_vote] = {
                        ID : impID,
                        no : count_vote
                    }
                    
                    count_vote++; 
                    

                } else if($target.is(":checked") || $target.hasClass("checked")){
                    
                    var impID = $target.attr("data-impID");
                    for(var i = 0; i < vote.length; i++){
                        if(vote[i].ID == impID){
                            $("#zone").children()[vote[i].no].remove();
                            vote.splice(i,1)

                            for(var x = i; x < vote.length; x++){
                                vote[x].no = vote[x].no -1;
                            }
                        }
                    }
                    
                    if(count_vote > 0 && count_vote <= 3){
                        count_vote--;
                    }
                    
                }
            });
            
                            
            <?php 
                //ajout du vote qu'on vient d'ajouter
                if(!empty($_GET) && isset($_GET["slug"]) && $imp->slug == $_GET["slug"]){ 
            ?>
            $("#zone").append("<div class='<?php echo $_GET["slug"]; ?> vote col-xs-12 col-md-4 no-select' data-impID='<?php echo $_GET["slug"]; ?>'><span><?php echo $_GET["text"]; ?><input type='hidden' name='vote-"+count_vote+"' value='<?php echo $_GET["id"]; ?>'></span></div>");

            vote[count_vote] = {
                ID : <?php echo $_GET["id"]; ?>,
                no : count_vote
            }

            count_vote++; 

            <?php        
                }
            ?>
        });
    </script>
    <!--Fin de bulles de vote-->