<?php

function notEmpty($post, $nom)
{
    if (empty($post)) {
        return "<li>le champ $nom ne doit pas etre vide</li>";
    }
}
function valideChamps($expreg, $post, $nom)
{
    if (!preg_match($expreg, $post)) {
        return "<li>le $nom est invalide</li>";
    }
}
//vérification de la date 
function valideDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    if ($d && $d->format($format) == $date) {
        return true;
    } else {
        return false;
    }
}
function valideToDate($post)
{
    if (!valideDate($post)) {
        return "<li>la date est invalide</li>";
    }
}
