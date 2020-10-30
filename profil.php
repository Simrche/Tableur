<?php 
    session_start();
    $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "");

    $paris =  $bdd->prepare('SELECT * FROM parisTerminer WHERE par_pseudo=:pseudo ORDER BY par_id DESC;' );
    $tout = 0;
?>

<?php include 'inc/header-inc.php'; ?>

        <section id="profil">
            <h1><?php echo $_GET['profil']?></h1>
            <?php $paris->execute(array('pseudo' => $_GET['profil'])) ;
            
                
                    foreach($paris as $pari) :
                    $tout = $tout + ( $pari['par_cote']*$pari['par_mise']-$pari['par_mise']);
                    if($pari['par_gagnant'] === "salut") {?>
                        <div class='proto'>
                            <p class='vert'><?php echo $pari['par_id']?></p>
                            <p class='vert'><?php echo $pari['par_pseudo'] ?></p>
                            <p class='vert'><?php echo $pari['par_titre'] ?></p>
                            <p class='vert'><?php echo $pari['par_mise'] ?>€</p>
                            <p class='vert'><?php echo $pari['par_cote'] ?></p>
                            <p class='vert'><?php echo $pari['par_cote']*$pari['par_mise']-$pari['par_mise']?>€</p>
                        </div>
                    <?php 
                    } else { ?>
                        <div class='proto'>
                        <p class='red'><?php echo $pari['par_id']?></p>
                        <p class='red'><?php echo $pari['par_pseudo'] ?></p>
                        <p class='red'><?php echo $pari['par_titre'] ?></p>
                        <p class='red'><?php echo $pari['par_mise'] ?>€</p>
                        <p class='red'><?php echo $pari['par_cote'] ?></p>
                        <p class='red'><?php echo $pari['par_mise']-$pari['par_mise']-$pari['par_mise']?>€</p>
                    </div>
                <?php  } endforeach ?>
           <p id="total">RESULTAT : <?php echo $tout ?>€</p>
        </section>
        
    </body>
</html>