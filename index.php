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
            <div class="jumbotron">
                <h1>Welkom op rarevragen.nl</h1>
            </div>
            
            <?php
                connectDB();
                
            ?>
        </div>

    </body>

</html>
