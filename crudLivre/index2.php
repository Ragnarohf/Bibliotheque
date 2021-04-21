<?php include "../head.php";
require "../pdo.php";
$error = null;

try {
    if (!empty($_GET['id_livre'])) {

        $statementDel = $pdo->prepare("DELETE from livre where id_livre = :id_livre");
        $statementDel->execute(["id_livre" => $_GET['id_livre']]);
    }
    $statement = $pdo->query("SELECT * from livre");
    $livres = $statement->fetchAll();
?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">auteur</th>
                <th scope="col">titre</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($livres as $livre) {
            ?>
                <tr class="table-warning">
                    <td><?= $livre['auteur'] ?></td>
                    <td><?= $livre['titre'] ?></td>
                    <td><a href="modification.php?id_livre=<?= $livre['id_livre'] ?>">Modification<a></td>
                    <td><a href="index2.php?id_livre=<?= $livre['id_livre'] ?>">Supression<a></td>
                </tr>
        <?php

            }
        } catch (PDOException $exception) {
            $error = $exception->getMessage();
        }
        ?>
        </tbody>
    </table>
    <button type="button" class="btn btn-secondary"><a href="insertion.php">Inserer un abonné</a></button>