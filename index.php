<html>

<head>
    <?php 
            include_once('functions/mainfunctions.php');
            include_once('includes/links.php');
        ?>
    
    <script type="text/javascript">
        function roep_vragen(){
            $.ajax({
                type: 'POST', 
                url: 'laadt_vragen.php', // here posting value to your php file
                data: {
                    my_value : $('#categorie').val()
                },
                success: function (answer) {
                    $("#vragen").html(answer) // here you can define an alert function for after success or you can use it with an id for showing the response
                }
            })
        }
        
        function search_vragen(){
            $.ajax({
                type: 'POST', 
                url: 'search_vragen.php', // here posting value to your php file
                data: {
                    my_value : $('#search_vragen').val(),
                    categorie: $('#categorie').val()
                },
                success: function (answer) {
                    $("#vragen").html(answer) // here you can define an alert function for after success or you can use it with an id for showing the response
                }
            })
        }
    </script>
    
</head>

<body>
    <?php include_once("includes/header.php"); ?>
    <div class="container">
        <div class="jumbotron">
            <h1>Welkom op rarevragen.nl</h1>
        </div>

        <div class="row" style="padding-right: 15px">
            <div class="col-md-8" style="background-color: white;">

                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" id="categorie" name="categorie" onchange='roep_vragen();'>
                            <option>Algemeen</option>
                            <option>Natuur</option>
                            <option>Technologie</option>
                            <option>Mens & samenleving</option>
                            <option>Pornografie</option>
                            <option>Humor</option>
                            <option>Sander</option>
                            <option>Tering</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control"  placeholder="Zoeken" name="search_vragen" id="search_vragen" oninput="search_vragen();">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>  
                            </span>
                        </div>
                    </div>
                </div>
                
                <hr>
                <div id="vragen">
                    <?php
                    try{
                        $conn = connectDB();          
                        $sql = 'SELECT * FROM vragen INNER JOIN gebruikers ON vragen.id_gebruiker = gebruikers.id WHERE vragen.categorie = "Algemeen" ORDER BY vraag_id DESC';

                        foreach ($conn->query($sql) as $row) {
                        echo '
                            <div class="vraag_blok">
                                <div class="vraag_blok_foto">
                                    <a href="gebruikers.php?gebruikers_id='.$row['id_gebruiker'].'"><img src="images/default.png" style="height: 30px; width: 30px" class="img-circle"></a>
                                </div>
                                <a href="vraag.php?id='. $row['vraag_id'] .'">
                                    <span style="font-size: 18px; color: black">'. $row['vraag'] . '</span>
                                </a>
                                <span class="vraag_blok_gebruiker"><br>'.$row['bekeken'].' keer bekeken sinds '. $row['datum'] .', '. $row['tijdstip'] .'
                                </span>   
                            </div>'
                        ;
                        }
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                    ?>
                </div>

            </div>
            <div class="col-md-4" style="background-color: #eee; padding: 20px;">
                <?php if(!isset($_SESSION['id'])): ?>
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
                
                <?php 
                    $stmt = $conn->prepare("SELECT * FROM vragen WHERE id_gebruiker =" . $_SESSION['id']);
                    $stmt->execute();
                    $tekst = "Jouw aantal gestelde vragen: " . $stmt->rowCount();
                    echo '<p style="font-family: Montserrat;">' . $tekst . '</p>';
                
                ?>
            </div>

            </div>
        </div>
</body>

</html>
