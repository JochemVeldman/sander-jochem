<html>

<head>
    <?php 
            include_once('functions/mainfunctions.php');
            if(is_loggedin()){
                header('Location: index.php');
            }
            include_once('includes/links.php');
        ?>
</head>

<body>
    <?php 
            include_once("includes/header.php"); 
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_button'])){
                $gebruikersnaam = test_input($_POST["gebruikersnaam"]);
                $email = test_input($_POST["email"]);
                $wachtwoord = test_input($_POST["wachtwoord"]);
                $wachtwoord2 = test_input($_POST["wachtwoord2"]);

                $melding = '';
                
                try{
                    $conn = connectDB();
                    $g = false;
                    $e = false;
                    $errors = array();
                    $errorBericht = '';

                    //checken of gebruikersnaam al gebruikt is
                    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE gebruikersnaam=:gebruikersnaam LIMIT 1");
                    $stmt->execute(array(':gebruikersnaam'=>$gebruikersnaam));
                    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

                    if($stmt->rowCount() > 0){
                        //gebruikersnaam bestaat al
                        $errors['gebruikersnaam'] = 'Gebruikersnaam bestaat al.';
                    }else{
                        $g = true;
                    }

                    //checken of email al gebruikt is
                    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE email=:email LIMIT 1");
                    $stmt->execute(array(':email'=>$email));
                    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

                    if($stmt->rowCount() > 0){
                        //email bestaat al
                        $errors['email'] = 'E-mailaders bestaat al.';
                    }else{
                        $e = true;
                    }

                    if($g == true && $e == true){
                        $wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

                        $statement = $conn->prepare("INSERT INTO gebruikers(email, gebruikersnaam, wachtwoord, datum_aangemaakt)
                            VALUES(:email, :gebruikersnaam, :wachtwoord, :datum_aangemaakt)");
                        $statement->execute(array(
                            "email" => $email,
                            "gebruikersnaam" => $gebruikersnaam,
                            "wachtwoord" => $wachtwoord,
                            "datum_aangemaakt" => date("Y-m-d")
                        ));

                        $values = array(); // empty values array
                        $melding = '<p class="bg-success" style="padding: 5px; margin-bottom: 5px; border-radius: 3px; font-family: Montserrat;">Bedankt voor het registreren. U kunt nu inloggen. </p>';
                    }
                }catch(PDOException $e){
                    echo $e->getMessage();
                }
            }
        ?>

    <div class="container">
        <div id="registreren_container" style="width: 50%">
            <?php if($melding == '') : ?>
            <form method="POST" action="">
                <?php 
                            if($melding != ''){
                                echo $melding;
                            }
                        ?>
                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" onInput="check_gebruikersnaam()" value="<?php if(isset($_POST['gebruikersnaam'])){echo $_POST['gebruikersnaam'];} ?>">
                    <?php                        
                                if(isset($errors['gebruikersnaam'])){
                                    echo '<p class="bg-danger" style="padding: 5px; margin-top: 5px; border-radius: 3px">'. $errors['gebruikersnaam'] .'</p>';
                                }
                            ?>
                </div>
                <div class="form-group">
                    <label for="email">Email adres:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                    <?php                        
                                if(isset($errors['email'])){
                                    echo '<p class="bg-danger" style="padding: 5px; margin-top: 5px; border-radius: 3px">'. $errors['email'] .'</p>';
                                }
                            ?>
                </div>
                <div class="form-group">
                    <label for="pwd">Wachtwoord:</label>
                    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" onInput="check_pw()">
                </div>
                <div class="form-group">
                    <label for="pwd">Wachtwoord herhalen:</label>
                    <input type="password" class="form-control" id="wachtwoord2" name="wachtwoord2" onInput="check_pw()">
                </div>
                <button type="submit" class="btn btn-default" id="submit_button" name="submit_button" disabled>Submit</button>
            </form>
            <?php 
                    else : echo $melding;
                    endif; 
                ?>

        </div>
    </div>

    <script>
        $('#gebruikersnaam').tooltip({
            'trigger': 'focus',
            'title': 'Tussen de 4 en 15 karakters.',
            'placement': 'right'
        });
        $('#email').tooltip({
            'trigger': 'focus',
            'title': 'Gebruik een geldig e-mail adres.',
            'placement': 'right'
        });
        $('#wachtwoord').tooltip({
            'trigger': 'focus',
            'title': 'Tussen de 6 en 15 karakters.',
            'placement': 'right'
        });
        $('#wachtwoord2').tooltip({
            'trigger': 'focus',
            'title': 'Herhaal hier het wachtwoord.',
            'placement': 'right'
        });

        var pwOK = false;
        var gnOK = false;


        function enable_button() {
            if (pwOK == true && gnOK == true) {
                document.getElementById("submit_button").disabled = false;
            }
        }

        function check_pw() {
            var wachtwoord = document.getElementById("wachtwoord").value;
            var wachtwoord2 = document.getElementById("wachtwoord2").value;
            //hier is ww gelijk
            if (wachtwoord == wachtwoord2 && wachtwoord.length > 5 && wachtwoord.length < 16) {
                document.getElementById("wachtwoord2").style.borderColor = "#ccc";
                pwOK = true;
            } else {
                //hier is het niet gelijk
                document.getElementById("wachtwoord2").style.borderColor = "red";
            }

            enable_button();
        }

        function check_gebruikersnaam() {
            var gebruikersnaam = document.getElementById("gebruikersnaam").value;

            if (gebruikersnaam.length > 3 && gebruikersnaam.length < 16) {
                document.getElementById("gebruikersnaam").style.borderColor = "#ccc";
                gnOK = true;
            } else {
                document.getElementById("gebruikersnaam").style.borderColor = "red";
            }

            enable_button();
        }

    </script>
</body>

</html>
