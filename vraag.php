<html>

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
        
        ?>
        <?php         
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_reactie'])){
                $reactie = test_input($_POST["plaats_reactie"]);
                
                $conn = connectDB();

                $statement = $conn->prepare("INSERT INTO reacties(reactie, gebruiker_id, vraag_id, datum, tijdstip)
                    VALUES(:reactie, :gebruiker_id, :vraag_id, :datum, :tijdstip");
                $statement->execute(array(
                    "reactie" => $reactie,
                    "gebruiker_id" => $_SESSION['id'],
                    "vraag_id" => $_GET['id'],
                    "datum" => date("Y-m-d"),
                    "tijdstip" => date("h:i:sa"),
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

        <div class="row" style="padding-right: 15px">
            <div class="col-md-6" style="background-color: white;">
                <form method="POST" action="">
                    <div class="form-group">
                        <textarea placeholder="Plaats reactie" type="text" class="form-control" id="plaats_reactie" name="plaats_reactie" onInput="check_reactie()"></textarea>
                    </div>


                    <button type="submit" class="btn btn-default" id="submit_reactie" name="submit_reactie" disabled>Plaats reactie</button>
                </form>
            </div>
            <div class="col-md-4 col-md-offset-2" style="background-color: #eee; padding: 20px;">
                Gevraagd door:
                <?php echo '<a href="gebruikers.php?id=3">'.$row['gebruikersnaam']. '</a><br>';?>
                <?php echo $row['bekeken']; ?> keer bekeken sinds
                <?php echo $row['datum']; ?>
            </div>
        </div>
    </div>
    <script>
        var reactieOK = false;

        function enable_button() {
            if (reactieOK == true) {
                document.getElementById("submit_button").disabled = false;
            } else {
                document.getElementById("submit_button").disabled = true;
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
