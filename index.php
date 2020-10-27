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

        }?>

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
                    if($pari['gagnant'] === "on") {?>
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
                    <input type="checkbox" placeholder="Paris gagné ?" name="gagner">
                    <input type="submit" id="envoyer" name="submit">
                </form>
        </section>

    </body>
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/main.js"></script>

</html>