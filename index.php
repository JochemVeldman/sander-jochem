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
            <div class="row" style="padding-left: 15px; padding-right: 15px">
                <div class="col-md-8">
                
                </div>
                <div class="col-md-4" style="background-color: #eee; padding: 20px;">
                    <?php if(!isset($_SESSION['id'])) : ?> <!-- if logged in... -->
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
            </div>
        </div>
    </body>

</html>
