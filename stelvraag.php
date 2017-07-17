<html>

<head>
    <?php 
            include_once('functions/mainfunctions.php');
            
            if(!is_loggedin()){
                header('Location: stelvraag_reg_log.php');
            }
        
            include_once('includes/links.php');
        ?>

</head>

<body>
    <?php 
            include_once("includes/header.php"); 
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_button'])){
                $vraag = test_input($_POST["vraag"]);
                $opmerking = test_input($_POST["opmerking"]);
                $categorie = test_input($_POST["categorie"]);
                
                $conn = connectDB();

                $statement = $conn->prepare("INSERT INTO vragen(vraag, opmerking, categorie, datum, tijdstip, id_gebruiker)
                    VALUES(:vraag, :opmerking, :categorie, :datum, :tijdstip, :id_gebruiker)");
                $statement->execute(array(
                    "vraag" => ucfirst($vraag),
                    "opmerking" => $opmerking,
                    "categorie" => $categorie,
                    "datum" => date("Y-m-d"),
                    "tijdstip" => date("h:i:sa"),
                    "id_gebruiker" => $_SESSION['id']
                ));
                $melding = true;
                
            }
        
        ?>

    <div class="container">
        <div class="col-md-8 col-md-offset-2">
            <div id="stelvraag_container">
                <?php
                        if ($melding == true){
                            echo '<p class="bg-success" style="padding: 15px; font-family: Montserrat; text-align: center; margin-bottom: 5px; border-radius: 3px">Uw vraag is met succes geplaatst.</p>';
                        }
                    ?>
                    <form method="POST" action="<?php echo htmlspecialchars('stelvraag.php');?>">
                        <div class="form-group">
                            <label for="Titel">Vraag:</label>
                            <input type="text" class="form-control" id="titel_vraag" name="vraag" onInput="check_titel()">
                        </div>
                        <div class="form-group">
                            <label for="Vraag">Opmerking:</label>
                            <textarea type="text" class="form-control" id="vraag" name="opmerking"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Categorie">Categorie:</label>
                            <input type="text" class="form-control" id="categorie_vraag" name="categorie" list="suggestions">
                            <datalist id="suggestions">
                                <option value="Algemeen">
                                <option value="Natuur">
                                <option value="Technologie">
                                <option value="Mens & samenleving">
                                <option value="Pornografie">
                                <option value="Humor">
                                <option value="Sander">
                                <option value="Tering">
                            </datalist>
                        </div>
                        <div class="checkbox" style="font-family: Montserrat; margin-bottom: 15px;">
                            <label><input type="checkbox" id="checkboxstelvraag" value="" name="checkboxstelvraag">Ik ben tevreden met mijn vraag en plaats hem graag op de website*.</label>
                        </div>
                        <button type="submit" class="btn btn-default" id="submit_button" name="submit_button" disabled>Plaats vraag</button>
                    </form>
            </div>
        </div>
    </div>

    <script>
        $('#titel_vraag').tooltip({
            'trigger': 'focus',
            'title': 'Een goede beknopte vraag vergroot de kans op een goed antwoord',
            'placement': 'left'
        });
        $('#vraag').tooltip({
            'trigger': 'focus',
            'title': 'Een opmerking is optioneel maar ondersteunt de vraag zodat ander zodat andere gebruikers deze beter kunnen beantwoorden',
            'placement': 'left'
        });
        $('#categorie_vraag').tooltip({
            'trigger': 'focus',
            'title': 'Een categorie toevoegen is optioneel maar met een categorie zullen meer mensen je vraag bekijken',
            'placement': 'left'
        });

        var titelOK = false;
        
        $('#checkboxstelvraag').click(function() {
            check_titel();
        });

        function enable_button() {
            if (titelOK == true && document.getElementById("checkboxstelvraag").checked) {
                document.getElementById("submit_button").disabled = false;
            } else {
                document.getElementById("submit_button").disabled = true;
            }
        }

        function check_titel() {
            var titel = document.getElementById("titel_vraag").value;
            if (titel.length > 5) {
                document.getElementById("titel_vraag").style.borderColor = "#ccc";
                titelOK = true;
            } else {
                document.getElementById("titel_vraag").style.borderColor = "red";
                titelOK = false;
            }
            enable_button()
        }

    </script>




</body>

</html>
