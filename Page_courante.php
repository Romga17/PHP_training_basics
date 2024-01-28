<?php
    //Démarrage d'une session et définition de l'id:
    session_start();
    $id_session = session_id();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <title>Plus_Minus_The_Game</title>
</head>
<body>

<?php

//Définition du message au lancement du jeu
$messageIni = 'Please choose a number between 0 and 100';
$_SESSION['messageIni']=$messageIni;

$message_plus = 'DAMMMMNNN, so close.. maybe you should try to increase the value..just saying..' . '<br>' . '<br>' . 'Here a reminder of your previous tries:';
$_SESSION['message_plus']=$message_plus;

$message_minus = 'DAMMMMNNN, so close.. maybe you should try to lower the value..just saying..' . '<br>' . '<br>' . 'Here a reminder of your previous tries:';
$_SESSION['message_minus']=$message_minus;


//Définition du chiffre aléatoire de la partie avec la méthode rand() qu'on enregristre dans la session:
    $randNum;

    if(isset($_SESSION['randNum'])){
    }else {
        $randNum = rand(0,100);
        $_SESSION['randNum']=$randNum;
    }
?>

<!-- Présentation du premier formulaire: -->
<img
    src="https://swanlibraries.net/wp-content/uploads/2018/03/cropped-SWAN-header-background-image-01.png"
    class="img-fluid rounded-top"
    alt="fond header"
    width="1520px"
/>


<h1 class="title" style="color:#E2883B"><u> Plus - Minus: The Game </u></h1>
<div class="containeraction">
    <form class="actionform" action="" method='post'>

    <label for="number" style="font-family: 'Roboto', font-size:24"> <?php echo $_SESSION['messageIni'] ?> </label>
    <input type="number" id="number" name="number" min="0" max="100" />

    <button type="submit">Confirm your choice</button>

    </form>

    <?php
    // Vérification de la réception de donnée via méthode POST du formulaire qui génère un tableau:
        if($_POST){
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $_SESSION['number'] = $_POST['number'];

                    } else {
                    //header('location: Page_courante.php');
                    }

                    // Vérification des données reçues par le formulaire:
                    $lasttry = intval($_SESSION['number']);
                    

                    //Initialisation de la liste qui va stocker l'ensemble de nos essais:
                    if(isset($_SESSION['completelist'])){
                        array_push ($_SESSION['completelist'], $lasttry);
                    }else {
                        $_SESSION['completelist']=array();
                        array_push ($_SESSION['completelist'], $lasttry);
                    }

                    if (filter_input(INPUT_POST, $lasttry, FILTER_VALIDATE_INT) !== FALSE){

                    
                    }else {
                        echo 'Input not valid';
                    }

                    // Gestion nombre d'essais limités:
                    $triescount = count($_SESSION['completelist']);

                    if ($triescount > 10){
                        header("Location: looser.php");
                        session_destroy();
                        exit();
                    }

                    //Gestion d'indications "plus" ou "moins" et validation partie gagnée:

                    if ($lasttry !== $_SESSION['randNum']){
                        if ($lasttry < $_SESSION['randNum']){
                            echo $_SESSION['message_plus'];
                            echo '<br>';
                            echo '<br>';
                            echo implode(", ", $_SESSION['completelist']);
                            exit();

                        } else{
                            echo $_SESSION['message_minus'];
                            echo '<br>';
                            echo '<br>';
                            echo implode(", ", $_SESSION['completelist']) ;
                            exit();
                        }
                    }else {
                        header("Location: winner.php");
                        session_destroy();
                    }
                    
                }else {
                    echo 'Enter a value to start the game !';
                }
                echo '<br>';
                ?>
        </div>
    </body>
</html>