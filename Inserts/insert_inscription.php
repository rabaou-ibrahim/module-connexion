<!DOCTYPE html>
<html>
<head>
<title><?php echo "Inscription" ?></title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<?php 
// Cette page "insert_inscription.php" se relie à la base de données, 
// et recherche ce qui a été renseigné dans le formulaire avec les variables $_POST.
// Puis, on exécute l'insertion dans le code php, et un nouvel enregistrement si l'on ne trouve pas d'erreur 
// sera ajouté à la table "utilisateurs".
?>

<?php

// Ici on va taper plusieurs conditions //

// 1ère condition : Les champs ne sont pas remplis

if (empty($_POST['login']) or empty($_POST['nom']) or empty($_POST['prenom']) or empty($_POST['password']) or empty($_POST['confirmed_password'])) {
  echo ("<main>
			<p> ERREUR </p>
            <p> Les champs ne sont pas entièrement remplis. </p> 
            Retournez à la page d'inscription ou à l'index :
            <br>
            <br>
            <a href='../inscription.php'<li> M'inscrire </li></a>
            <br>
            <br>
            <a href='../index.php'<li> Page d'accueil </li></a>
            <br>
            <br>
        </main>
        ");
}

// 2ème condition : Les mots de passe ne sont pas identiques

elseif (($_POST['password']) != ($_POST['confirmed_password'])) {
  echo ("<main>
			<p> ERREUR </p>
            <p> Les mots de passes ne sont pas identiques. </p> 
            Retournez à la page d'inscription ou à l'index :
            <br>
            <br>
            <a href='../inscription.php'<li> M'inscrire </li></a>
            <br>
            <br>
            <a href='../index.php'<li> Page d'accueil </li></a>
            <br>
            <br>
        </main>
        ");
} 

// 3ème condition : Si tous les champs sont remplis alors :
elseif (isset($_POST['login']) && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['password']) && ($_POST['confirmed_password'])) {

  include('connexion_db.php'); // Connexion à la bdd

  $login = $_POST['login']; // On attribue des variables aux login et mot de passe renseignées 
  $password = $_POST['password'];

  // On vérifie si le login et mot de passe sont pas déjà pris

  $req = mysqli_query($conn, "SELECT password, login FROM utilisateurs WHERE password = 'admin' AND login = 'admin'"); // requête pour    	 verifier si le mot de passe et login nommés 'admin' existent déjà
  $num_rows = mysqli_num_rows($req); // Compter le nombre de ligne ayant rapport a la requette SQL
  if ($num_rows > 0) { // Si une ligne est concernée par la requête c'est que le mot de passe est déjà pris           
    // donc on affiche un message d'erreur
    if ($login === 'admin' && $password === 'admin') {
      echo ("<main>
			  <p> ERREUR </p>
            <p> Changez de login et de mot de passe. On ne peut pas avoir deux admins. </p> 
            Retournez à la page d'inscription ou à l'index :
            <br>
            <br>
            <a href='../inscription.php'<li> M'inscrire </li></a>
            <br>
            <br>
            <a href='../index.php'<li> Page d'accueil </li></a>
            <br>
            <br>
        </main>
        ");
    } 
    
    else { // Si login et mot de passe ne valent pas 'admin' on regarde ensuite 
      // si le mdp et le login ne sont pas déjà pris

      $req = mysqli_query($conn, "SELECT password, login FROM utilisateurs WHERE password = '$password' AND login = '$login'"); // requête pour    verifier si le mot de passe et login renseignés n'existent pas déjà
      $num_rows = mysqli_num_rows($req); // Compter le nombre de ligne ayant rapport a la requette SQL
      if ($num_rows > 0) { // Si une ligne est concernée par la requête c'est que le mot de passe est déjà pris           
        // donc on affiche un message d'erreur
        echo ("<main>
          <p> ERREUR </p>
          <p> Mot de passe et login déjà pris. </p> 
          Retournez à la page d'inscription ou à l'index :
          <br>
          <br>
          <a href='../inscription.php'<li> M'inscrire </li></a>
          <br>
          <br>
          <a href='../index.php'<li> Page d'accueil </li></a>
          <br>
          <br>
        </main>
        ");
      } 
      
      else { // Si le login ET le mdp ne sont pas déjà pris on vérifie ensuite
        // si un utilisateur possède déjà le login tapé par la personne qui s'inscrit
        $req = mysqli_query($conn, "SELECT login FROM utilisateurs WHERE login = '$login'"); // requête pour verifier si le login renseigné n'existe pas déjà
        $num_rows = mysqli_num_rows($req); // Compter le nombre de ligne ayant rapport a la requette SQL
        if ($num_rows > 0) { // Si une ligne est concernée par la requête c'est que le login est déjà pris           
          // donc on affiche un message d'erreur
          echo ("<main>
          <p> ERREUR </p>
            <p> Login déjà pris. </p> 
            Retournez à la page d'inscription ou à l'index :
            <br>
            <br>
            <a href='../inscription.php'<li> M'inscrire </li></a>
            <br>
            <br>
            <a href='../index.php'<li> Page d'accueil </li></a>
            <br>
            <br>
          </main>
          ");
        }
        else {// Si le login n'est pas déjà pris on vérifie ensuite
            // si un utilisateur possède déjà le mot de passe tapé par la personne qui s'inscrit
            $req = mysqli_query($conn, "SELECT password FROM utilisateurs WHERE password = '$password'"); // requête pour verifier si le mot de passe renseigné n'existe pas déjà
            $num_rows = mysqli_num_rows($req); // Compter le nombre de ligne ayant rapport a la requette SQL
            if ($num_rows > 0) { // Si une ligne est concernée par la requête c'est que le mot de passe est déjà pris           
            // donc on affiche un message d'erreur
            echo ("<main>
            <p> ERREUR </p>
              <p> Mot de passe déjà pris. </p> 
              Retournez à la page d'inscription ou à l'index :
              <br>
              <br>
              <a href='../inscription.php'<li> M'inscrire </li></a>
              <br>
              <br>
              <a href='../index.php'<li> Page d'accueil </li></a>
              <br>
              <br>
            </main>
            ");
            }
            else {
              // Si on arrive à cette dernière condition c'est que tous les champs
              // sont remplis ET que le login et mdp tapés n'appartiennent pas déjà à qqun
              // L'utilisateur peut donc s'inscrire

              include('connexion_db.php'); // Connexion à la base de données
            
              $login = $_POST['login'];   // Attribution de variables 
              $prenom = $_POST['prenom'];
              $nom = $_POST['nom'];
              $password = $_POST['password'];
              // Requête qui va ajouter l'utilisateur dans la table 'utilisateurs'
              $sql = "INSERT INTO utilisateurs
              VALUES (0, '$login', '$prenom', '$nom', '$password')";
                 
              if ($conn->query($sql) === TRUE) { // Si la requête est bonne on affiche ce message
                echo ("<main>                    
                        <p> Inscription réussie ! </p> 
                          Vous pouvez désormais vous connecter :
                          <br>
                          <br>
                          <a href='../connexion.php'<li> Me connecter</li></a>
                          <br>
                          <br>
                          OU retourner à l'index
                          <br>
                          <br>
                          <a href='../index.php'<li> Page d'accueil </li></a>
                          <br>
                          <br>
                      </main>
                    ");   
                }
$conn->close();                   
            }
        }
      }
    }
  }
}

?>