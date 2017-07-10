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

        <?php include_once("includes/header.php"); ?>

        
        <div class="container">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){   
                    $gebruikersnaam = test_input($_POST["gebruikersnaam"]);
                    $email = test_input($_POST["email"]);
                    $wachtwoord = test_input($_POST["wachtwoord"]);
                    $wachtwoord2 = test_input($_POST["wachtwoord2"]);
                        
                    register($email, $gebruikersnaam, $wachtwoord);
                    
                    echo 'Bedankt voor het registreren. Om uw account te activeren moet u op de link klikken in de e-mail die wij naar u verzonden hebben. Hierna kunt u inloggen.';
                }else{
                    header('Location: registreren.php');
                }
            
            ?>
        </div>

    </body>

</html>
