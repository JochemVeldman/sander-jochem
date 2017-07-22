<?php
    $value = $_POST['my_value'];
    $categorie = $_POST['categorie'];
    include_once('functions/mainfunctions.php');

    try{
        $conn = connectDB();          
        $sql = 'SELECT * FROM vragen WHERE vraag LIKE "%'.$value.'%" AND categorie = "'.$categorie.'" ORDER BY vraag_id DESC';

        foreach ($conn->query($sql) as $row) {
        echo '
            <div class="vraag_blok">
                <div class="vraag_blok_foto">
                    <a href="gebruikers.php?gebruikers_id='.$row['id_gebruiker'].'"><img src="images/default.png" style="height: 30px; width: 30px" class="img-circle"></a>
                </div>
                <a href="vraag.php?id='. $row['vraag_id'] .'">
                    <span style="font-size: 18px; color: black">'. $row['vraag'] . '</span>
                </a>
                <span class="vraag_blok_gebruiker"><br>'.$row['bekeken'].' keer bekeken sinds '. $row['datum'] .', '. $row['tijdstip'] .'
                </span>   
            </div>'
        ;
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }



?>