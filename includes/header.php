<nav class="navbar navbar-default">
    <div class="container-fluid">
        
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand active" href="index.php"><b>Rarevragen.nl  <span class="sr-only">(current)</span></b></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">Categorieën</a></li>
                <li><a href="stelvraag.php">Stel vraag</a></li>

            </ul>
            
            <?php if(isset($_SESSION['id'])) : ?> <!-- if logged in... -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['gebruikersnaam']; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true" style="margin-right: 12px;"></span> Mijn profiel</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true" style="margin-right: 12px;"></span> Instellingen</a></li>
                        <li><a href="afmelden.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true" style="margin-right: 12px;"></span> Afmelden</a></li>
                    </ul>
                    </li>
                </ul>
            <?php else : ?> <!-- if not logged in... -->
                <form class="navbar-form navbar-right" style="padding: 0" method="POST" action="">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Gebruikersnaam/e-mail" id="login_gebruikersnaam" name="login_gebruikersnaam" style="width: auto;" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Wachtwoord" style="width: 120px" id="login_wachtwoord" name="login_wachtwoord" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="loginButton">Login</button>
                </form>
            <?php endif; ?>
            
            
            
        </div><!-- /.navbar-collapse -->
        </div>
    </div><!-- /.container-fluid -->
</nav>        