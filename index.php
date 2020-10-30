<?php 
    session_start();
    $yes = 0;
    $oui = "oui";
    $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");
    $bdd->query("CREATE TABLE parisTerminer(
        par_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
        par_pseudo VARCHAR(255),
        par_titre VARCHAR(255),
        par_cote DECIMAL(6,2),
        par_mise DECIMAL(6,2),
        par_gagnant VARCHAR(25)
        );");

$bdd->query("CREATE TABLE chat(
    message_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
    chat_message VARCHAR(255),
    chat_pseudo VARCHAR(255),
    chat_heure DATETIME
    );");
    
    $erreur = "";
    
    $requete = $bdd->prepare("INSERT INTO chat(chat_message, chat_pseudo, chat_heure) VALUES(?, ?, NOW());");
    
    $messages =  $bdd->query("SELECT message_id as id, chat_message as message, chat_pseudo as pseudo, chat_heure as heure FROM chat ORDER BY message_id DESC LIMIT 0, 10;");
    
    if (!empty($_SESSION['pseudo']))
    {
        if (isset($_POST['sendMessage']))
        {
            if (iconv_strlen($_POST['message']) <= 140)
            {
                $requete->execute(array($_POST['message'], $_SESSION['pseudo']));
                header("Location: index.php");
            }
            else{
                $erreur = "<p class='erreur'>Le message ne doit pas depasser 140 caractères. Espece de petit spameur !";
            }
    
        }
    } else {
        if(isset($_POST['sendMessage'])) {
            header('location: connexion.php');
        }
    }
    $requete = $bdd->prepare("INSERT INTO parisTerminer(par_pseudo, par_titre, par_cote, par_mise, par_gagnant) VALUES(?, ?, ?, ?, ?);");

    if(isset($_POST['submit'])) {
        $requete->execute(array($_SESSION['pseudo'], $_POST['titre'], $_POST['cote'], $_POST['mise'], $_POST['gagner']));
    }

    $paris =  $bdd->query("SELECT par_pseudo as pseudo, par_id as id, par_titre as titre, par_cote as cote, par_mise as mise, par_gagnant as gagnant FROM parisTerminer ORDER BY par_id DESC;");
    $classement = $bdd->query('SELECT par_mise as mise, par_cote as cote FROM parisTerminer WHERE par_pseudo="Simrche"');
?>

<?php include 'inc/header-inc.php'; ?>

        <?php 

        if($_SESSION['pseudo'] != "") {

        echo "
        <section id='ajoutPari'>
            <button id='ajouter'>+</button>
            <h2>AJOUTER UN PARI</h2>
        </section>";
        } else {
         echo "
         <section id='ajoutPari'>
            <a href='connexion.php'>Connectez vous pour pouvoir ajouter des paris</a> 
        </section>";
        }
            
            ?>

        <section id="projet">
            <div id="classement">
                <h3>Classement</h3>
                <?php 
                    foreach($classement as $classements) :
                        $yes = $yes + ($classements['cote']*$classements['mise']-$classements['mise']);
                    endforeach;
                    echo $yes;
                ?>
            </div>
            <div id='parisRecent'>
                <div class="proto">
                    <p><span class="gras">N°</span></p>
                    <p><span class="gras">Pseudo</span></p>
                    <p><span class="gras">Titre</span></p>
                    <p><span class="gras">Mise</span></p>
                    <p><span class="gras">Cote</span></p>
                    <p><span class="gras">Gains</span></p>
                </div>
                <?php foreach($paris as $pari) :
                    if($pari['gagnant'] != null) {?>
                        <div class='proto'>
                            <p class='vert'><?php echo $pari['id']?></p>
                            <p class='vert'><?php echo $pari['pseudo'] ?></p>
                            <p class='vert'><?php echo $pari['titre'] ?></p>
                            <p class='vert'><?php echo $pari['mise'] ?>€</p>
                            <p class='vert'><?php echo $pari['cote'] ?></p>
                            <p class='vert'><?php echo $pari['cote']*$pari['mise']-$pari['mise']?>€</p>
                        </div>
                    <?php 
                    } else { ?>
                        <div class='proto'>
                        <p class='red'><?php echo $pari['id']?></p>
                        <p class='red'><?php echo $pari['pseudo'] ?></p>
                        <p class='red'><?php echo $pari['titre'] ?></p>
                        <p class='red'><?php echo $pari['mise'] ?>€</p>
                        <p class='red'><?php echo $pari['cote'] ?></p>
                        <p class='red'><?php echo $pari['mise']-$pari['mise']-$pari['mise']?>€</p>
                    </div>
                <?php  } endforeach ?>
            </div>
            <div id="enligne">
                <h3>En ligne</h3>
                <form method="post" action="index.php" id="formChat">
						<h3>Salut <?php echo $_SESSION['pseudo'];?> !</h3><br>
						<?php echo $erreur; ?>
						<div>
							<input type="text" name="message">
						</div><br>
						<input type="submit" name="sendMessage">
						<input type="submit" value='Deconnexion' name='decon'>
					</form><br>
                    <div id="chat">
                <?php 
	          		foreach($messages as $message) : ?>

		          	<?php 
		          		$msg = htmlspecialchars($message['message']);
		          	?>

		            <div class='testD'><p class="chatMSG"><?php echo '<span>' . $message['pseudo'] . '</span> : ' . $msg; ?></p></div>

		          	<?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="popup">
            <div id="popupFond">

            </div>
                <form method="post" action="index.php" id="popupMilieu">
                    <input type="text" placeholder="Entrez un titre" id="titre" name="titre">
                    <input type="int" placeholder="Côte" id="cote" name="cote">
                    <input type="int" placeholder="Mise" id="mise" name="mise">
                    <h2>Si votre pari est gagnant cochez la case</h2>
                    <input type="checkbox" placeholder="Paris gagné ?" name="gagner" value="salut">
                    <input type="submit" id="envoyer" name="submit">
                </form>
        </section>

    </body>
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/main.js"></script>

</html>