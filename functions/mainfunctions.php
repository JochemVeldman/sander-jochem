<?php

    function connectDB(){
        $servername = "localhost";
        $username = "sandefj230_rarevragen";
        $password = "62f5tfx7";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=sandefj230_rarevragen", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn; 
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }


    function register($email, $gebruikersnaam, $wachtwoord){
        $conn = connectDB();
        
        $statement = $conn->prepare("INSERT INTO gebruikers(email, gebruikersnaam, wachtwoord)
            VALUES(:email, :gebruikersnaam, :wachtwoord)");
        $statement->execute(array(
            "email" => $email,
            "gebruikersnaam" => $gebruikersnaam,
            "wachtwoord" => $wachtwoord
        ));
    }

    function login($gebruikersnaam,$email,$wachtwoord){
        try{
            $stmt = $this->db->prepare("SELECT * FROM gebruikers WHERE gebruikersnaam=:gebruikersnaam OR email=:email LIMIT 1");
            $stmt->execute(array(':gebruikersnaam'=>$gebruikersnaam, ':email'=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                if(password_verify($wachtwoord, $userRow['wachtwoord'])){
                    $_SESSION['user_session'] = $userRow['id'];
                    return true;
                }
                else{
                    return false;
                }
            }
        }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
    }

    function is_loggedin(){
        if(isset($_SESSION['id'])){
            return true;
        }
    }

    function redirect($url){
        header("Location: $url");
    }

    function logout(){
        session_destroy();
        unset($_SESSION['id']);
        return true;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
