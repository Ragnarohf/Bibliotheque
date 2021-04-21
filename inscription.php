<?php
include "pdo.php";
include "head.php";
require "validation.php";
$error = null;
$hash = null;
if (isset($_POST['inscription'])) {
    $error .= notEmpty($_POST['nom'], "nom");
    $error .= notEmpty($_POST['prenom'], "prenom");
    $error .= notEmpty($_POST['birthdate'], "date de naissance");
    $error .= notEmpty($_POST['email'], "email");
    $error .= notEmpty($_POST['password'], "mot de passe");
    if (!empty($_POST['password'])) {
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    }
    // var_dump($_FILES);
    //validation code postal  "/^[0-9]{5,5}$/ "
    $error .= valideChamps("/^[0-9]{5,5}$/ ", $_POST['codeP'], "code postal");
    $error .= valideToDate($_POST['birthdate']);

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error .= "<li>l'mail est invalide</li>";
    }

    //file avatar
    $file = $_FILES['avatar'];
    $fileName = $file['name'];
    $fileError = $file['error'];
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];
    $dossierTechargement = "upload";
    $tabExtension = ["png", "jpeg", "jpg", "jfif"];
    $fileExtnsion = explode(".", $fileName);

    $fileExt = strtolower(end($fileExtnsion));
    // var_dump($fileExtnsion, $fileExt);
    if (!dir($dossierTechargement)) {
        mkdir($dossierTechargement);
    }

    if (empty($fileError)) {
        if (in_array($fileExt, $tabExtension)) {

            if ($fileSize < 500000) {
                $fileNewName = uniqid("monImage--") . "." . $fileExt;
                $fileDestination = $dossierTechargement . "/" . $fileNewName;
                move_uploaded_file($fileTmp, $fileDestination);
            } else {
                echo "le fichier ne doit depasser le 50 ko";
            }
        } else {
            echo "l'extension $fileExt n'est pas accepté veillez choisir un fichier valide (png, jpeg,jpg)";
        }
    } else {
        echo "<li>erreur dans votre fichier</li>";
    }

    var_dump($_POST);
    if (empty($error)) {
        if (empty($fileError)) {
            $statement = $pdo->prepare("INSERT INTO abonne(nom,prenom,birthDate,email,password,adresse,codeP,avatar)values(:nom,:prenom,:birthdate,:email,:password,:adresse,:codeP,:avatar)");
            $statement->execute([
                "nom" => strip_tags($_POST['nom']),
                "prenom" => strip_tags($_POST['prenom']),
                "birthdate" => $_POST['birthdate'],
                "email" => strip_tags($_POST['email']),
                "password" => $hash,
                "adresse" => strip_tags($_POST['adresse']),
                "codeP" => strip_tags($_POST['codeP']),
                "avatar" => $fileNewName

            ]);
        } else {
            $statement = $pdo->prepare("INSERT INTO abonne(nom,prenom,birthDate,email,password,adresse,codeP)values(:nom,:prenom,:birthdate,:email,:password,:adresse,:codeP)");
            $statement->execute([
                "nom" => strip_tags($_POST['nom']),
                "prenom" => strip_tags($_POST['prenom']),
                "birthdate" => strip_tags($_POST['birthdate']),
                "email" => strip_tags($_POST['email']),
                "password" => $hash,
                "adresse" => strip_tags($_POST['adresse']),
                "codeP" => strip_tags($_POST['codeP'])

            ]);
        }
        header("location:connexion.php");
    }
}


?>
<style>
    form {
        width: 60%;
        margin: auto;
    }
</style>


<div> partie connexion

    <a href="connexion.php ">connexion</a>
</div>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="">nom</label>
        <input type="text" class="form-control" name="nom" placeholder="nom">
    </div>
    <div class="form-group">
        <label for="">prenom</label>
        <input type="text" class="form-control" name="prenom" placeholder="prenom">
    </div>
    <div class="form-group">
        <label for="">date naissance</label>
        <input type="date" class="form-control" name="birthdate" placeholder="date naissance">
    </div>
    <div class="form-group">
        <label for="">adresse</label>
        <input type="text" class="form-control" name="adresse" placeholder="adresse">
    </div>
    <div class="form-group">
        <label for="">code Postal</label>
        <input type="number" class="form-control" name="codeP" placeholder="codePostal">
    </div>
    <div class="form-group">
        <label for="">email</label>
        <input type="text" class="form-control" name="email" placeholder="email">
    </div>
    <div class="form-group">
        <label for="">password</label>
        <input type="text" class="form-control" name="password" placeholder="password">
    </div>
    <div class="form-group">
        <label for="">photo profil</label>
        <input type="file" class="form-control" name="avatar">
    </div>
    <button type="submit" class="btn btn-secondary" name="inscription">inscription</button>

</form>
<?php
if (!empty($error)) {

?>
    <div class="alert alert-dismissible alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?= $error ?></strong>
    </div>
<?php
}
?>