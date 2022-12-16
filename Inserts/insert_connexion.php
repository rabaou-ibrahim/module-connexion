<!DOCTYPE html>
<html>
<head>
<title><?php echo "Inscription" ?></title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<?php

session_start();

// 1ère condition : Si on clique sur 'envoyer' dans la page connexion

if (isset($_POST['Envoyer'])) { 

    include('connexion_db.php'); // On se connecte à la base de données

    $login = $_POST['login'];  // On attribue des variables aux login et mot de passe reseignées 
    $password = $_POST['password'];

    // 2ère condition : Si aucun champ n'est rempli

    if (empty($login) and empty($password)) { // Si rien n'a été tapé 
        echo ("<main>
        <p> ERREUR </p>
        <p> Le login et le mot de passe doivent être renseignés. </p> 
        Retournez à la page de connexion ou à l'index :
        <br>
        <br>
        <a href='../connexion.php'<li> Me connecter </li></a>
        <br>
        <br>
        <a href='../index.php'<li> Page d'accueil </li></a>
        <br>
        <br>
    </main>");
    }

    // 3ème condition : Si le champ login n'est pas rempli

    elseif (empty($login)) { 
        echo ("<main>
        <p> ERREUR </p>
        <p> Le login doit être renseigné. </p> 
        Retournez à la page de connexion ou à l'index :
        <br>
        <br>
        <a href='../connexion.php'<li> Me connecter </li></a>
        <br>
        <br>
        <a href='../index.php'<li> Page d'accueil </li></a>
        <br>
        <br>
    </main>");
    }

    // 4ème condition : Si le mot de passe n'a pas été tapé

    elseif (empty($password)) {
        echo ("<main>
        <p> ERREUR </p>
        <p> Le mot de passe doit être renseigné. </p> 
        Retournez à la page de connexion ou à l'index :
        <br>
        <br>
        <a href='../connexion.php'<li> Me connecter </li></a>
        <br>
        <br>
        <a href='../index.php'<li> Page d'accueil </li></a>
        <br>
        <br>
    </main>");
    } 
    
        // Sinon (càd dans le cas où les 2 champs sont remplis)
        // On fait notre requête qui consiste à vérifier si l'utilisateur qui s'identifie est l'admin ou non
        // On regarde dans la bdd si le login et le mot de passe tapés est admin
    
    // 5ème condition : Si les 2 champs sont remplis

    elseif (isset($_POST['login']) && isset($_POST['password'])) {
        
        // On fait une requête qui cherche si on a déjà un utilisateur qui a déjà
        // comme login et mot de passe "admin"

        $sql = "SELECT * FROM utilisateurs WHERE login = 'admin' AND password = 'admin'";
        $result = mysqli_query($conn, $sql);
        
        // Si on en trouve un on vérifie si l'utilisateur entre les codes de l'admin

        if (mysqli_num_rows($result) === 1) {
            // Si c'est le cas, on redirige l'admin vers la page admin
            if ($login === 'admin' && $password === 'admin') {
            header("Location:../admin.php"); // On redirige l'utilisateur à la page admin
                    $_SESSION['login'] = $login;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['password'] = $password;
            }

            else {
            // Si l'utilisateur n'a pas tapé 'admin' en login et mdp on fait notre requête 
            // qui consiste à selectionner les logins/mots de passes enregistrés dans la bdd
                
            $sql = "SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'";
            $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    // Si la ligne contenant le bon login et le bon mot de passe est trouvée dans la bdd,
                    if ($row['login'] === $login && $row['password'] === $password) {
                        header("Location:../welcome.php"); // On redirige l'utilisateur à la page welcome
                        $_SESSION['login'] = $login;
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['password'] = $password;
                    }
                }

                else { // Dans le dernier des cas, le login et/ou mot de passe est incorrect
                    echo ("<main> 
                            <p> Mot de passe et/ou login incorrect. </p> 
                                Retournez à la page de connexion ou à l'index :
                                <br>
                                <br>
                                <a href='../connexion.php'<li> Retenter de me connecter</li></a>
                                <br>
                                <br>
                                <a href='../index.php'<li> Page d'accueil </li></a>
                                <br>
                                <br>
                                </main>
                    ");
                }
            }
        }
    }
}

        
    

$conn->close();
?>