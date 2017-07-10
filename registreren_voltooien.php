<html>
    <head>
        <?php 
            include_once('functions/mainfunctions.php');
        ?>
        
        <link rel="stylesheet" type="text/css" href="css/main.css">
        
        <!-- Latest compiled and minified CSS for bootstrap-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- include jquery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
        <!-- Latest compiled and minified JavaScript for bootstrap -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php 
        include_once("includes/header.php"); 
        ?>
        
        <div class="container">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                    var_dump($_POST);
                    
                    $gebruikersnaam = test_input($_POST["gebruikersnaam"]);
                    $email = test_input($_POST["email"]);
                    $wachtwoord = test_input($_POST["wachtwoord"]);
                    $wachtwoord2 = test_input($_POST["wachtwoord2"]);
                        
                    register($email, $gebruikersnaam, $wachtwoord);
                    
                    
                }else{
                    header('Location: registreren.php');
                }
            
            ?>
        </div>
    </body>
</html>