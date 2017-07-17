<html>
<!--goede versie -->

<head>
    <?php 
            include_once('functions/mainfunctions.php');
            include_once('includes/links.php');
        
            try{
                $conn = connectDB();
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "UPDATE vragen SET bekeken=bekeken+1 WHERE vraag_id=".$_GET['id'];
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }catch(PDOException $e){
                echo $sql . "<br>" . $e->getMessage();
            }
        
    
            try{
                $conn = connectDB();

                $stmt = $conn->prepare("SELECT * FROM vragen INNER JOIN gebruikers ON id = id_gebruiker WHERE vraag_id = :id LIMIT 1");
                $stmt->execute(array(':id'=>$_GET['id']));
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e)
            {
               echo $e->getMessage();
            }
        
            $conn = null;
        ?>
    <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_reactie'])){
                
                $conn = connectDB();

                $statement = $conn->prepare("INSERT INTO reacties(reactie, gebruiker_id, vraag_id, datum, tijdstip)
                    VALUES(:reactie, :gebruiker_id, :vraag_id, :datum, :tijdstip)");
                
                $statement->execute(array(
                    "reactie" => test_input($_POST["plaats_reactie"]),
                    "gebruiker_id" => $_SESSION['id'],
                    "vraag_id" => $_GET['id'],
                    "datum" => date("Y-m-d"),
                    "tijdstip" => date("h:i:sa")
                ));
                $melding = true;
            }
        
        ?>
</head>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="jumbotron">
            <h1>
                <?php echo $row['vraag']; ?>
            </h1>
            <p>
                <?php echo $row['opmerking']; ?>
            </p>
        </div>

        <div class="row" style="padding-right: 0px">

            <div class="col-md-6" style="background-color: white;">
                <?php
                        if ($melding == true){
                            echo '<p class="bg-success" style="padding: 15px; font-family: Montserrat; text-align: center; margin-bottom: 15px; border-radius: 3px">U reactie is met succes geplaatst.</p>';
                        }
                    ?>
                    <?php 
                    if(is_loggedin()){
                        echo '
                        <form method="POST" action="">
                            <div class="form-group">
                                <textarea placeholder="Plaats reactie" type="text" class="form-control" style="height: 80px;" id="plaats_reactie" name="plaats_reactie" onInput="check_reactie()"></textarea>
                            </div>
                            <button type="submit" class="btn btn-default" id="submit_reactie" name="submit_reactie" disabled>Plaats reactie</button>
                        </form>
                        <br>';
                    }else {
                        echo '
                        <div class="col-md-12" style="background-color: #eee; padding: 20px; margin-bottom: 15px;">
                            <p><b>Om een reactie te plaatsen moet u inloggen of <a href="registreren.php">registreren</a></b></p>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Gebruikersnaam/e-mail" id="login_gebruikersnaam" name="login_gebruikersnaam" required style="margin-top: 3px">
                                    <input type="password" class="form-control" placeholder="Wachtwoord" id="login_wachtwoord" name="login_wachtwoord" required style="margin-top: 3px">
                                    <button type="submit" class="btn btn-success" name="loginButton" style="margin-top: 3px">Login</button>
                                </div>
                            </form>
                        </div>';
                    }
                ?>
            </div>
            <div class="container">
                <div class="col-md-4 col-md-offset-2" style="background-color: #eee; padding: 20px; margin-bottom: 20px;">
                    Gevraagd door:
                    <?php echo '<a href="gebruikers.php?id=3">'.$row['gebruikersnaam']. '</a><br>';?>
                    <?php echo $row['bekeken']; ?> keer bekeken sinds
                    <?php echo $row['datum']; ?>
                </div>
            </div>
            <?php
                    try{
                        $conn = connectDB();          
                        $sql = 'SELECT * FROM reacties INNER JOIN gebruikers ON reacties.gebruiker_id = gebruikers.id WHERE vraag_id =' . $_GET['id'] . ' ORDER BY reacties.reactie_id DESC';
                
                        foreach ($conn->query($sql) as $row) {
                            echo '<div class="col-md-6" style="margin-right:1px;"><div class="vraag_blok"><p style= "font-family: Montserrat; padding-bottom: 10px; padding-left: 5px; font-size: 14px;">' . $row['reactie'] . ' ' . '</p><p style="font-size: 11px; font-family: Montserrat; padding-left: 5px;">' . $row['gebruikersnaam'] . ' ' . $row['datum'] . ' ' . $row['tijdstip'] . '</p></div></div>';
                        }
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }

                ?>

        </div>
    </div>
    <script>
        var reactieOK = false;

        function enable_button() {
            if (reactieOK == true) {
                document.getElementById("submit_reactie").disabled = false;
            } else {
                document.getElementById("submit_reactie").disabled = true;
            }
        }

        function check_reactie() {
            var reactie = document.getElementById("plaats_reactie").value;
            if (reactie.length > 0) {
                document.getElementById("plaats_reactie").style.borderColor = "#ccc";
                reactieOK = true;
            } else {
                document.getElementById("plaats_reactie").style.borderColor = "red";
                reactieOK = false;
            }
            enable_button()
        }

    </script>
</body>

</html>
