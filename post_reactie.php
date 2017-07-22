<?php
    include_once('functions/mainfunctions.php');
    $conn = connectDB();

    $statement = $conn->prepare("INSERT INTO reacties(reactie, gebruiker_id, vraag_id, datum, tijdstip)
        VALUES(:reactie, :gebruiker_id, :vraag_id, :datum, :tijdstip)");

    $statement->execute(array(
        "reactie" => $_POST['plaats_reactie'],
        "gebruiker_id" => $_SESSION['id'],
        "vraag_id" => $_POST['vraag_id'],
        "datum" => date("Y-m-d"),
        "tijdstip" => date("H:i:sa")
    ));
?>

<div class="reactie_blok">
    <p style= "font-family: Montserrat; font-size: 14px;">
        <?php echo $_POST['plaats_reactie']; ?>
    </p>
    <p style="font-family: Montserrat; font-size: 12px; padding-bottom: 7px;">
        <?php 
            echo $_SESSION['gebruikersnaam'] . ', ' . date("Y-m-d") . ', ' . date("H:i:sa");
            
        ?>
    </p>
</div>