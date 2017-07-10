<html>
    <head>
        <?php 
            include_once('functions/mainfunctions.php');
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
                        <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" onInput="check_gebruikersnaam()">
                    </div>
                    <div class="form-group">
                        <label for="email">Email adres:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Wachtwoord:</label>
                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" onInput="check_pw()">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Wachtwoord herhalen:</label>
                        <input type="password" class="form-control" id="wachtwoord2" name="wachtwoord2" onInput="check_pw()">
                    </div>             
                    <button type="submit" class="btn btn-default" id="submit_button" disabled>Submit</button>
                </form>
            </div>
        </div>
        
        <script>
            $('#gebruikersnaam').tooltip({'trigger':'focus', 'title': 'Tussen de 4 en 15 karakters.', 'placement' : 'right'});
            $('#email').tooltip({'trigger':'focus', 'title': 'Gebruik een geldig e-mail adres.', 'placement' : 'right'});
            $('#wachtwoord').tooltip({'trigger':'focus', 'title': 'Tussen de 6 en 15 karakters.', 'placement' : 'right'});
            $('#wachtwoord2').tooltip({'trigger':'focus', 'title': 'Herhaal hier het wachtwoord.', 'placement' : 'right'});
            
            var pwOK = false;
            var gnOK = false;
            
            
            function enable_button(){
                if(pwOK == true && gnOK == true){
                    document.getElementById("submit_button").disabled = false;
                }
            }    
            
            function check_pw(){
                var wachtwoord = document.getElementById("wachtwoord").value;
                var wachtwoord2 = document.getElementById("wachtwoord2").value;
                //hier is ww gelijk
                if(wachtwoord == wachtwoord2 && wachtwoord.length > 5 && wachtwoord.length < 16){
                    document.getElementById("wachtwoord2").style.borderColor = "#ccc";
                    pwOK = true;
                }else{
                    //hier is het niet gelijk
                    document.getElementById("wachtwoord2").style.borderColor = "red";
                }
                
                enable_button();
            }
            
            function check_gebruikersnaam(){
                var gebruikersnaam = document.getElementById("gebruikersnaam").value;
                
                if(gebruikersnaam.length > 3 && gebruikersnaam.length < 16){
                    document.getElementById("gebruikersnaam").style.borderColor = "#ccc";
                    gnOK = true;
                }else{
                    document.getElementById("gebruikersnaam").style.borderColor = "red";
                }
                
                enable_button();
            }
        </script>
    </body>
</html>

