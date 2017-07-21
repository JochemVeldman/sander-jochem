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
                    "tijdstip" => date("H:i:sa")
                ));
                $melding = true;
            }
        
        ?>
        <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_omhoog'])){                   $conn = connectDB();

                $score = 1;                    
                    
                $statement = $conn->prepare("INSERT INTO likes_vragen(vraag_id, gebruiker_id, waardering)
                    VALUES(:vraag_id, :gebruiker_id, :waardering)");
                    
                $statement->execute(array(
                    "vraag_id" => $_GET['id'],
                    "gebruiker_id" => $_SESSION['id'],
                    "waardering" => $score
                ));
            }
        ?>

            <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_omlaag'])){
        $conn = connectDB();
        $score = 0;

        $statement = $conn->prepare("INSERT INTO likes_vragen(vraag_id, gebruiker_id, waardering)
            VALUES(:vraag_id, :gebruiker_id,  :waardering)");

        $statement->execute(array(
            "vraag_id" => $_GET['id'],
            "gebruiker_id" => $_SESSION['id'],
            "waardering" => $score
        ));
    } 

        ?>

</head>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="jumbotron" style="padding: 20px">
            <div class="row">
                <div class="col-md-2">
                    <div style="height: 200px; width: 120px">
                        <div style="height: 120px; width: 100%; background-color: white; border: 1px solid #D9D9D9; padding: 2px">
                            <img src="images/default.png" style="height: 100%; width: 100%">
                        </div>
                        <div style="width: 100%; height: 80px; padding: 5px">
                            <?php echo '<a href="gebruikers.php?gebruikers_id='.$row['id_gebruiker'].'">' . $row['gebruikersnaam'] . '</a>';?>
                            <br>
                            <?php      
                                echo 'Posts: ' . gebruikers_posts($row['id_gebruiker']);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <h2>
                        <?php echo $row['vraag']; ?>
                    </h2>
                    <br>
                    <?php echo $row['opmerking']; ?>
                    <hr style="border-top: 1px solid #D9D9D9;">
                    <span style="font-size: 12px; color: #696969">Geplaatst op: <?php echo $row['datum'] . ', ' . $row['tijdstip'] . '. Sindsdien '.$row['bekeken'] . ' keer bekeken.'; ?></span>
                </div>
            </div>
        </div>

        <form method="POST" action="">
            <button type="submit" class="btn btn-default" id="submit_waardering" name="submit_omlaag">Omlaag</button>
            <button type="submit" class="btn btn-default" id="submit_waardering" name="submit_omhoog">Omhoog</button>
        </form>

        <hr>
        <div class="row">
            <div class="col-md-8" style="background-color: white;">
                <?php
                        if ($melding == true){
                            echo '<p class="bg-success" style="padding: 15px; font-family: Montserrat; text-align: center; margin-bottom: 15px; border-radius: 3px">Uw reactie is met succes geplaatst.</p>';
                        }
                    ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <textarea placeholder="Plaats reactie" type="text" class="form-control" style="height: 80px;" id="plaats_reactie" name="plaats_reactie" onInput="check_reactie()"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default" id="submit_reactie" name="submit_reactie" disabled>Plaats reactie</button>
                    </form>
                    <br>


                    <?php
                    try{
                        $conn = connectDB();          
                        $sql = 'SELECT * FROM reacties INNER JOIN gebruikers ON reacties.gebruiker_id = gebruikers.id WHERE vraag_id =' . $_GET['id'] . ' ORDER BY reacties.reactie_id DESC';
                
                        foreach ($conn->query($sql) as $row) {
                            echo '<div class="reactie_blok"><p style= "font-family: Montserrat; font-size: 14px;">' . $row['reactie'] . '</p>' . '<p style="font-family: Montserrat; font-size: 12px; padding-bottom: 7px;">' . $row['gebruikersnaam'] . ' ' . $row['datum'] . ' ' . $row['tijdstip'] . '</p>' . '</div>';
                        }
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }

                ?>
            </div>

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
