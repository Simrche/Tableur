<?php 
    if(isset($_POST['decon'])) {
        session_destroy();
        header('location: connexion.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <title>Tableur</title>
    </head>

    <body>
        
        <header>
            <h1><a href="index.php">TABLEUR</a></h1>

            <div class="salut">
            <?php 
            
            if($_SESSION['pseudo'] == '') {
                echo "<a href='connexion.php'>CONNEXION</a> <a href='inscription.php'>INSCRIPTION</a>";
            } else {
                echo "<p id='bonjour'>Bonjour, ". $_SESSION['pseudo'] ."</p><a href='profil.php'>Mon Profil</a><form method='post'><input id='aussi' type='submit' name='decon' value='DECO'></form>";
            }
            
            ?>
            </div>
            
        </header>