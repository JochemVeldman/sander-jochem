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
        ?>
        
        <div class="container">
            <div class="col-md-8 col-md-offset-2">
                <div id="stelvraag_container">
                    <form method="POST" action="<?php echo htmlspecialchars('registreren_voltooien.php');?>">
                        <div class="form-group">
                            <label for="Titel">Titel:</label>
                            <input type="text" class="form-control" id="titel_vraag" name="gebruikersnaam">
                        </div>
                        <div class="form-group">
                            <label for="Vraag">Vraag:</label>
                            <textarea type="text" class="form-control" id="vraag" name="email"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Categorie">Categorie:</label>
                            <input type="text" class="form-control" id="categorie_vraag" name="wachtwoord">
                        </div>        
                        <button type="submit" class="btn btn-default" id="submit_button">Plaats vraag</button>
                    </form>
                </div>
            </div>
        </div>
        
        <script>
            var wachtwoord = document.getElementById("wachtwoord").value;
            var wachtwoord2 = document.getElementById("wachtwoord2").value;
            
            if(wachtwoord == wachtwoord2){
                document.getElementById("submit_button").disabled = false;   
            }
        </script>
    </body>
</html>

