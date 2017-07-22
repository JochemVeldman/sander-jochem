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
            
        
        ?>
        <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_omhoog'])){
                    $conn = connectDB();
                    $stmt = $conn->prepare("SELECT * FROM likes_vragen WHERE gebruiker_id = :gebruiker_id AND vraag_id = :vraag_id");
                    $stmt->execute(array(':gebruiker_id'=>$_SESSION['id'], ':vraag_id' => $_GET['id']));
                    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

                    if($stmt->rowCount() > 0){
                        $conn = connectDB();
                        $stmt = "UPDATE likes_vragen SET waardering='1' WHERE gebruiker_id = :gebruiker_id AND vraag_id = :vraag_id";
                        $stmt->execute(array(':gebruiker_id'=>$_SESSION['id'], ':vraag_id' => $_GET['id']));
                    
                    }else{
                        $score = 1;                    

                        $statement = $conn->prepare("INSERT INTO likes_vragen(vraag_id, gebruiker_id, waardering)
                            VALUES(:vraag_id, :gebruiker_id, :waardering)");

                        $statement->execute(array(
                            "vraag_id" => $_GET['id'],
                            "gebruiker_id" => $_SESSION['id'],
                            "waardering" => $score
                        ));;
                    }

            }else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_omlaag'])){
                $conn = connectDB();
                $stmt = $conn->prepare("SELECT * FROM likes_vragen WHERE gebruiker_id = :gebruiker_id AND vraag_id = :vraag_id");
                $stmt->execute(array(':gebruiker_id'=>$_SESSION['id'], ':vraag_id' => $_GET['id']));
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

                if($stmt->rowCount() > 0){
                    echo 'al geliked'; 
                }else{
                    $score = 0;                    
                    
                    $statement = $conn->prepare("INSERT INTO likes_vragen(vraag_id, gebruiker_id, waardering)
                        VALUES(:vraag_id, :gebruiker_id, :waardering)");
                    
                    $statement->execute(array(
                        "vraag_id" => $_GET['id'],
                        "gebruiker_id" => $_SESSION['id'],
                        "waardering" => $score
                    ));;
                }

            } 
    
            $conn = connectDB();
            //SELECT * FROM likes_vragen WHERE gebruiker_id =". $_SESSION['id'] . "AND vraag_id =" . $_GET['id']
            $stmt = $conn->prepare("SELECT * FROM likes_vragen WHERE gebruiker_id = :gebruiker_id AND vraag_id = :vraag_id");
            $stmt->execute(array(':gebruiker_id'=>$_SESSION['id'], ':vraag_id' => $_GET['id']));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() > 0){
                echo 'al geliked'; 
            }else{
                echo 'Nog niet geliked';
            }

    
    
        ?>
            <script>
                $(document).ready(function() {
                    var submit = $('#submit_reactie');

                    $('#plaats_reactie').on('submit', function(e) {
                        // prevent default action
                        e.preventDefault();
                        // send ajax request
                        $.ajax({
                            url: 'post_reactie.php',
                            type: 'POST',
                            cache: false,
                            data: $('#plaats_reactie').serialize(), //form serizlize data
                            success: function(data) {
                                // Append with fadeIn see http://stackoverflow.com/a/978731
                                var item = $(data).hide().fadeIn(800);
                                $('#reacties').prepend(item);

                                // reset form and button
                                $('#plaats_reactie').trigger('reset');
                            },
                            error: function(e) {
                                alert(e);
                            }
                        });
                    });
                });

            </script>

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

                    <form method="POST" action="" id="plaats_reactie" name="plaats_reactie">
                        <div class="form-group">
                            <textarea placeholder="Plaats reactie" type="text" class="form-control" style="height: 80px;" id="plaats_reactie" name="plaats_reactie"></textarea>
                        </div>
                        <input type="hidden" value="<?php echo $_GET['id'];?>" name="vraag_id">
                        <button type="submit" class="btn btn-default" id="submit_reactie" name="submit_reactie">Plaats reactie</button>
                    </form>
                    <br>

                    <div id="reacties">
                    </div>
                    <?php
                            try{
                                $conn = connectDB();          
                                $sql = 'SELECT * FROM reacties INNER JOIN gebruikers ON reacties.gebruiker_id = gebruikers.id WHERE vraag_id =' . $_GET['id'] . ' ORDER BY reacties.reactie_id DESC';

                                foreach ($conn->query($sql) as $row) {
                                    echo '<div class="reactie_blok"><p style= "font-family: Montserrat; font-size: 14px;">' . $row['reactie'] . '</p>' . '<p style="font-family: Montserrat; font-size: 12px; padding-bottom: 7px;">' . $row['gebruikersnaam'] . ' ' . $row['datum'] . ', ' . $row['tijdstip'] . '</p>' . '</div>';
                                }
                            }
                            catch(PDOException $e){
                                echo $e->getMessage();
                            }

                        ?>

            </div>

        </div>
    </div>
</body>

</html>
