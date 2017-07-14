<html>

    <head>
        <?php 
            include_once('functions/mainfunctions.php');
            include_once('includes/links.php');
        
            try {
                $conn = connectDB();
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "UPDATE vragen SET bekeken='' WHERE id=".$_GET['id'];

                // Prepare statement
                $stmt = $conn->prepare($sql);

                // execute the query
                $stmt->execute();

                // echo a message to say the UPDATE succeeded
                echo $stmt->rowCount() . " records UPDATED successfully";
                }
            catch(PDOException $e)
                {
                echo $sql . "<br>" . $e->getMessage();
                }

            $conn = null;
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
                    links
                </div>
                <div class="col-md-4" style="background-color: #eee; padding: 20px;">
                    rechts
                </div>
            </div>
        </div>
    </body>

</html>
