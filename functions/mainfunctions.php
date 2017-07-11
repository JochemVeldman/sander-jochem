<?php
    session_start(); //once for all the files

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

    if(isset($_POST['loginButton'])){
        $gebruikersnaam = test_input($_POST['login_gebruikersnaam']);
        $wachtwoord = test_input($_POST['login_wachtwoord']);
        
        if(strlen($gebruikersnaam) > 0 && strlen($gebruikersnaam) < 32 && strlen($wachtwoord) > 0 && strlen($wachtwoord) < 32){
            login($gebruikersnaam, $wachtwoord);   
        }
    }

    function login($gebruikersnaam,$wachtwoord){
        try{
            $conn = connectDB();
            
            $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE gebruikersnaam=:gebruikersnaam OR email=:gebruikersnaam LIMIT 1");
            $stmt->execute(array(':gebruikersnaam'=>$gebruikersnaam, ':email'=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            
            if($stmt->rowCount() > 0){
                if(password_verify($wachtwoord, $userRow['wachtwoord'])){
                    $_SESSION['id'] = $userRow['id'];
                    $_SESSION['gebruikersnaam'] = $userRow['gebruikersnaam'];
                    $_SESSION['email'] = $userRow['email'];
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

    function logout(){
        session_destroy();
        unset($_SESSION['id']);
        header('Location: index.php');
        die;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>
