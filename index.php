<html>
    <head>
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
            $password = 'varkensoog';
        ?>
        <script>
            function myFunction(){
                var x;
                var name=prompt("Password?");
                if (name == "<?php print($password); ?>"){
                   alert('Welcome my Lord.');
                }else{
                    myFunction();
                }
            }
            
            window.onpaint = myFunction();
        </script>
        
        <?php include_once("includes/header.php"); ?>
        
        <div class="container">
            <div class="jumbotron">
                <h1>Welkom op rarevragen.nl</h1>
            </div>
        </div>
    </body>
</html>