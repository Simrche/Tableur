<?php 
    session_start();
    $_SESSION['pseudo'];
    $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $bdd->query("CREATE TABLE users(
        par_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
        users_pseudo VARCHAR(255),
        users_email VARCHAR(255),
        users_mdp VARCHAR(255)
        users_img
        );");

    $requete = $bdd->prepare("INSERT INTO users(users_pseudo, users_email, users_mdp) VALUES(?, ?, ?);");

    if(isset($_POST['inscription'])) {
        $requete->execute(array($_POST['pseudo'], $_POST['email'], $_POST['motdepasse']));
        header('location: connexion.php');
    }
?>

<?php include 'inc/header-inc.php'; ?>

        <section class='connect'>
            <form action="inscription.php" method="post">
                <h1>INSCRIPTION</h1>
                <input type="text" name="pseudo" placeholder=" Pseudo">
                <input type="text" name="email" placeholder=" Email">
                <input type="password" name="motdepasse" placeholder=" Mot de passe">
                <button name="inscription">Inscription</button>
            </form>
        </section>
        
    </body>
</html>