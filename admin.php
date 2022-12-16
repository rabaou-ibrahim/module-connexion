<?php 
//On demare la session sur sur cette page 
session_start() ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
     // Après avoir ouvert une session, on affiche le contenu de la variable session sur la ligne 28
     echo " 
            <header>
                    <br>
                    <a href='deconnexion.php'><li> Me déconnecter </li></a>
                    <br>
                    <br>
            </header>
     
            <main> 
                <p> Bonjour " .  $_SESSION['login'] . " ! </p> 
                <p> Voici la liste des utilisateurs ainsi que leurs données : </p>
                <br>
                <p>" . include('Inserts/connexion_db.php');
                $sql = 'SELECT * FROM utilisateurs';
                $result = $conn->query($sql);
                if (mysqli_num_rows($result) > 0) {
                        echo ("<u>.Utilisateurs :</u>");
                        echo("<li>");
                        echo('id');
                        echo ("|"); 
                        echo('login');
                        echo ("|");
                        echo('prenom');
                        echo ("|");
                        echo('nom');
                        echo ("|");
                        echo('mot de passe');
                        echo ("|");
                        echo ("<br>");
                    while ($row = $result->fetch_assoc()) {      
                        echo($row['id']);
                        echo ("|");
                        echo($row['login']);
                        echo ("|");
                        echo($row['prenom']);
                        echo ("|");
                        echo($row['nom']);
                        echo ("|");
                        echo($row['password']);
                        echo ("<br>");        
                    }
                    echo ("</li>");
                }
                "</p>
            </main>
          ";
    ?>
</body>
</html>