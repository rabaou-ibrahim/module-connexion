<?php

// On démarre la session

session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo "Connexion" ?></title>
<link rel="stylesheet" href="../style.css">
</head>

<body>

<?php

if (isset($_POST['Nouveau_login_confirmer'])) {
  // Si l'utilisateur valide une modification de login sans rien taper on lui renvoie 
  // le message d'erreur de la ligne 24 :
  if (empty($_POST['Nouveau_login_confirm'])) {
    echo ("Veuillez tapez un nouveau login ");
    echo ('<br>');
    echo ('<br>');
    echo ("<a href='../profil.php'><button>Retour</button></a>");
    exit();
  }

  elseif (($_POST['Nouveau_login_confirm'] === "admin")) {
    echo ("Vous ne pouvez pas avoir 'admin' comme login");
    echo ('<br>');
    echo ('<br>');
    echo ("<a href='../profil.php'><button>Retour</button></a>");
    exit();
  }

  else {

  include('connexion_db.php');
  $sql = "UPDATE utilisateurs   
  SET login = '$_POST[Nouveau_login_confirm]'
  WHERE id = '$_SESSION[id]'";
  $result = $conn->query($sql);

  if ($conn->query($sql) === TRUE) {
    echo("Modification réussie");
    echo("<br>");
    echo("<br>");
    echo ('<a href="../profil.php"><input type="submit" name="Retour" value="Retour"/></a>');
  }

  elseif ($conn->query($sql) === FALSE) {  // On met une message dans le cas où la requête est fausse
    echo ('ERREUR : La requête SQL a échouée');
  }

} 

$conn->close();

}

?>

</body>