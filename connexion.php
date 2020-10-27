<?php 
    session_start();

    $_SESSION['pseudo'] = "";
    $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $reponse =  $bdd->prepare('SELECT users_mdp FROM users WHERE users_pseudo=:pseudo');
    $error = '';

    if(isset($_POST['envoyer'])) {
        $pseudo = $_POST['pseudo'];
        $reponse->execute(array('pseudo' => $pseudo));
        $donnees = $reponse->fetch();
        if($_POST['mdp'] === $donnees['users_mdp']) {
            $_SESSION['pseudo'] = $_POST['pseudo'];
            header('Location: index.php');
        } else {
            $error = 'Mauvais identifiant ou mauvais mot de passe';

        }
    }

?>

<?php include 'inc/header-inc.php'; ?>

        <section class='connect'>
            <h1>CONNEXION</h1>
            <form action="connexion.php" method="post">
                <input type="text" name="pseudo" placeholder=' Pseudo'>
                <input type="password" name="mdp" placeholder=' Mot de passe'>
                <button name="envoyer">Connexion</button>
                <p><?php echo $error ?></p>
            </form>
        </section>
    </body>
</html>