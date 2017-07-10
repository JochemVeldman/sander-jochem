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
            <div id="registreren_container" style="width: 50%">
                <form method="POST" action="<?php echo htmlspecialchars('registreren_voltooien.php');?>">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam:</label>
                        <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam">
                    </div>
                    <div class="form-group">
                        <label for="email">Email adres:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Wachtwoord:</label>
                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Wachtwoord herhalen:</label>
                        <input type="password" class="form-control" id="wachtwoord2" name="wachtwoord2">
                    </div>             
                    <button type="submit" class="btn btn-default" id="submit_button" disabled>Submit</button>
                </form>
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

