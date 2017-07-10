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


    function register($email, $gebruikersnaam, $wachtwoord, $datum_aangemaakt){
        try{
            $nieuw_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO gebruikers(email, gebruikersnaam, wachtwoord, datum_aangemaakt) 
            VALUES(:email, :gebruikersnaam, :wachtwoord, :datum_aangemaakt)");

            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":gebruikersnaam", $gebruikersnaam);
            $stmt->bindparam(":wachtwoord", $wachtwoord);            
            $stmt->bindparam(":datum_aangemaakt", $datum_aangemaakt);            
            $stmt->execute(); 

            return $stmt; 
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }    
    }

    function login($uname,$umail,$upass){
        try{
            $stmt = $this->db->prepare("SELECT * FROM users WHERE user_name=:uname OR user_email=:umail LIMIT 1");
            $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                if(password_verify($upass, $userRow['user_pass'])){
                    $_SESSION['user_session'] = $userRow['user_id'];
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
        if(isset($_SESSION['user_session'])){
            return true;
        }
    }

    function redirect($url){
        header("Location: $url");
    }

    function logout(){
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
