<?php require "../pdo.php";
include "../head.php";
require "../validation.php";
$error = null;
// var_dump($_GET);
if (!empty($_GET)) {
    $livreStement = $pdo->prepare("select * from livre where id_livre= :id_livre");
    $livreStement->execute([
        "id_livre" => $_GET['id_livre']
    ]);
    $livre = $livreStement->fetch();
    // var_dump($livre);
}
if (isset($_POST['inserer'])) {

    $error = notEmpty($_POST['auteur'], "auteur");
    $error .= notEmpty($_POST['titre'], "titre");
    if (empty($error)) {
        $insertion =  $pdo->prepare("UPDATE livre set auteur=:auteur, titre = :titre where id_livre = :id_livre");
        $insertion->execute(
            [
                "auteur" => strip_tags($_POST['auteur']),
                "titre" => strip_tags($_POST['titre']),
                "id_livre" => strip_tags($_GET['id_livre'])
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
        <input type="text" class="form-control" name="auteur" value="<?= $livre['auteur'] ?>">
    </div>
    <div class="form-group">
        <label for="">titre</label>
        <input type="text" class="form-control" name="titre" value="<?= $livre['titre'] ?>">
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