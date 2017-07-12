<html>
    <head>
        <?php 
            include_once('functions/mainfunctions.php');
        ?>
        
        <?php 
            include_once('includes/links.php');
        ?>
        
    </head>
    <body>
        <?php 
            include_once("includes/header.php"); 
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_button'])){
                $titel = test_input($_POST["titel"]);
                $vraag = test_input($_POST["vraag"]);
                $categorie = test_input($_POST["categorie"]);
                
                $conn = connectDB();

                $statement = $conn->prepare("INSERT INTO vragen(titel, vraag, categorie, datum)
                    VALUES(:titel, :vraag, :categorie, :datum)");
                $statement->execute(array(
                    "titel" => $titel,
                    "vraag" => $vraag,
                    "categorie" => $categorie,
                    "datum" => date("Y-m-d")
                ));

            }
        
        ?>
        
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div id="stelvraag_container">
                    <form method="POST" action="<?php echo htmlspecialchars('registreren_voltooien.php');?>">
                        <div class="form-group">
                            <label for="Titel">Titel:</label>
                            <input type="text" class="form-control" id="titel_vraag" name="titel" onInput="check_titel()">
                        </div>
                        <div class="form-group">
                            <label for="Vraag">Vraag:</label>
                            <textarea type="text" class="form-control" id="vraag" name="vraag" onInput="check_vraag()"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Categorie">Categorie:</label>
                            <input type="text" class="form-control" id="categorie_vraag" name="categorie" onInput="check_categorie()">
                        </div>        
                        <button type="submit" class="btn btn-default" id="submit_button" disabled>Plaats vraag</button>
                    </form>
                </div>
            </div>
        </div>
        
        <script>

        </script>
        
        <script>
            $('#titel_vraag').tooltip({'trigger':'focus', 'title': 'Een goede titel vergroot de kans op een goed antwoord', 'placement' : 'left'});
            $('#vraag').tooltip({'trigger':'focus', 'title': 'Een beknopte vraagt zorgt ervoor dat iedereen sneller jou vraag begrijpt', 'placement' : 'left'});
            $('#categorie_vraag').tooltip({'trigger':'focus', 'title': 'Met een goede categorie zullen meer mensen je vraag bekijken', 'placement' : 'left'});
            
            
            var titelOK = false;
            var vraagOK = false;
            var categorieOK = false;
            
            function enable_button(){
                if(titelOK == true && vraagOK == true && categorieOK == true){
                    document.getElementById("submit_button").disabled = false;
                }
            }    
            
            function check_titel(){
                var titel = document.getElementById("titel_vraag").value;
                if(titel.length > 5){
                    document.getElementById("titel_vraag").style.borderColor = "#ccc";
                    titelOK = true;
                }else{
                    document.getElementById("titel_vraag").style.borderColor = "red"
                }
                enable_button()
            }
            
            function check_vraag(){
                var titel = document.getElementById("vraag").value;
                if(titel.length > 5){
                    document.getElementById("vraag").style.borderColor = "#ccc";
                    vraagOK = true;
                }else{
                    document.getElementById("vraag").style.borderColor = "red"
                }
                enable_button()
            }
            
            function check_categorie(){
                var titel = document.getElementById("categorie_vraag").value;
                if(titel.length > 5){
                    document.getElementById("categorie_vraag").style.borderColor = "#ccc";
                    categorieOK = true;
                }else{
                    document.getElementById("categorie_vraag").style.borderColor = "red"
                }
                enable_button()
            }
            
            
            
        </script>
        
        
        
        
    </body>
</html>

