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
                            <input type="text" class="form-control" id="titel_vraag" name="titel">
                        </div>
                        <div class="form-group">
                            <label for="Vraag">Vraag:</label>
                            <textarea type="text" class="form-control" id="vraag" name="vraag"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Categorie">Categorie:</label>
                            <input type="text" class="form-control" id="categorie_vraag" name="categorie">
                        </div>        
                        <button type="submit" class="btn btn-default" id="submit_button">Plaats vraag</button>
                    </form>
                </div>
            </div>
        </div>
        
        <script>

        </script>
    </body>
</html>

