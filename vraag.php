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
            <div class="col-md-8" style="background-color: white;">
                links
            </div>
            <div class="col-md-4" style="background-color: #eee; padding: 20px;">
                Gevraagd door:
                <?php echo '<a href="gebruikers.php?id=3">'.$row['gebruikersnaam']. '</a><br>';?>
                <?php echo $row['bekeken']; ?> keer bekeken sinds
            </div>
        </div>
    </div>
</body>

</html>
