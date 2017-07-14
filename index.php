<html>

<head>
    <?php 
            include_once('functions/mainfunctions.php');
            include_once('includes/links.php');
        ?>
</head>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="jumbotron">
            <h1>Welkom op rarevragen.nl</h1>
        </div>

        <div class="row" style="padding-right: 15px">
            <div class="col-md-8" style="background-color: white;">
                <?php
                    
                        try{
                            $conn = connectDB();          
                            $sql = 'SELECT * FROM vragen INNER JOIN gebruikers ON vragen.id_gebruiker = gebruikers.id ORDER BY id';
                            
                            foreach ($conn->query($sql) as $row) {
                                echo '<div class="vraag_blok"><a href="vraag.php?id='. $row['vraag_id'] .'">'. $row['vraag'] . '</a><span class="vraag_blok_gebruiker"> door <a href="gebruikers.php?gebruikers_id='.$row['id_gebruiker'].'">'. $row['gebruikersnaam'] .'</a><br>'.$row['bekeken'].' keer bekeken sinds '. $row['datum'] .', '. $row['tijdstip'] .'</span></div>';
                            }
                        }
                        catch(PDOException $e){
                            echo $e->getMessage();
                        }
                    
                    ?>


            </div>
            <div class="col-md-4" style="background-color: #eee; padding: 20px;">
                <?php if(!isset($_SESSION['id'])) : ?>
                <!-- if logged in... -->
                <p><b>Inloggen of <a href="registreren.php">registreren</a></b></p>
                <form method="POST" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Gebruikersnaam/e-mail" id="login_gebruikersnaam" name="login_gebruikersnaam" required style="margin-top: 3px">
                        <input type="password" class="form-control" placeholder="Wachtwoord" id="login_wachtwoord" name="login_wachtwoord" required style="margin-top: 3px">
                        <button type="submit" class="btn btn-success" name="loginButton" style="margin-top: 3px">Login</button>
                    </div>
                </form>

                <?php endif; ?>
            </div>

            <div class="col-md-4" style="background-color: #eee; padding: 20px; margin-top: 20px;">
                <?php 
                    $stmt = $conn->prepare("SELECT * FROM vragen WHERE id_gebruiker =" . $_SESSION['id']);
                    $stmt->execute();
                    echo $stmt->rowCount();
                
                ?>

            </div>
        </div>
    </div>
</body>

</html>
