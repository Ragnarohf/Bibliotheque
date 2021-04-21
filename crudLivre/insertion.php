<?php require "../pdo.php";
include "../head.php";
require "../validation.php";
$error = null;

if (isset($_POST['inserer'])) {

    $error = notEmpty($_POST['auteur'], "auteur");
    $error .= notEmpty($_POST['titre'], "titre");
    if (empty($error)) {
        $insertion =  $pdo->prepare("INSERT  INTO  livre(auteur,titre) values(:auteur,:titre)");
        $insertion->execute(
            [
                "auteur" => $_POST['auteur'],
                "titre" => $_POST['titre']
            ]
        );
        header("location:index2.php");
    }
}
?>
<style>
    form {
        width: 60%;
        margin: auto;
    }
</style>
<form action="" method="post">
    <div class="form-group">
        <label for="">auteur</label>
        <input type="text" class="form-control" name="auteur" placeholder="auteur">
    </div>
    <div class="form-group">
        <label for="">titre</label>
        <input type="text" class="form-control" name="titre" placeholder="titre">
    </div>
    <button type="submit" class="btn btn-secondary" name="inserer">Inserer</button>

</form>
<?php if (!empty($error)) {
?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?= $error ?></strong>
    </div>
<?php
} ?>
<button class="btn btn-info"><a href="index2.php">Back home</a></button>