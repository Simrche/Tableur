<?php 
session_start();
$bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");

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
			header("Location: chat.php");
		}
		else{
			$erreur = "<p class='erreur'>Le message ne doit pas depasser 140 caractères. Espece de petit spameur !";
		}

	}
	?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>Mini chat</title>
				<link rel="stylesheet" type="text/css" href="css/style.css">
			</head>

			<body>

				<section id="chat">

					<h1 id="titreChat">CHAT</h1>

					<form method="post" action="chat.php" id="formChat">
						<h3>Salut <?php echo $_SESSION['pseudo'];?> !</h3><br>
						<?php echo $erreur; ?>
						<div>
							<input type="text" name="message">
						</div><br>
						<input type="submit" name="sendMessage">
						<a href="deco.php">Deconnexion</a>
					</form><br>

						<?php 
	          		foreach($messages as $message) : ?>

		          	<?php 
		          		$msg = htmlspecialchars($message['message']);
		          	?>

		            <div><p class="chatMSG"><?php echo $message['pseudo'] . ' : ' . $message['heure'] . ' : ' . $msg; ?></p></div>

		          	<?php endforeach; ?>

          		</section>
			
			</body>
		</html>
	<?php
}
else{
	echo "Vous n'êtes pas connecter. <a href='connexion.php'>Se connecter</a>";
}


?>