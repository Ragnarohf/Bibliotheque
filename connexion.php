<?php

require "pdo.php";
include "head.php";
if (isset($_POST['connexion'])) {
    var_dump($_POST);
    $statement = $pdo->query("SELECT * from abonne where email = '$_POST[email]'");
    $abonne = $statement->fetch();
    var_dump($abonne);
    if ($abonne === false) {
        header("location:inscription.php");
    } else {
        if (password_verify($_POST['password'], $abonne['password'])) {
            $_SESSION['id'] = $abonne['id_abonne'];
            header("location:profil.php");
        }
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
        <div class="form-group">
            <label for="">email</label>
            <input type="text" class="form-control" name="email" placeholder="email">
        </div>
        <div class="form-group">
            <label for="">password</label>
            <input type="text" class="form-control" name="password" placeholder="password">
        </div>
        <button type="submit" class="btn btn-secondary" name="connexion">connexion</button>


</form>