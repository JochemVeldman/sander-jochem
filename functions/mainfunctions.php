<?php

function connectDB(){
    $servername = "localhost";
    $username = "sandefj230_rarevragen";
    $password = "62f5tfx7";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=sandefj230_rarevragen", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully"; 
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

?>
