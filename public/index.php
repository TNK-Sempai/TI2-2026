<?php
# public/index.php

/*
 * Front Controller de la gestion du livre d'or
 */

/*
 * Chargement des dépendances
 */
require_once "../config.php";
require_once URL_BASE . "/model/guestbookModel.php";

/*
 * Connexion à la base de données en utilisant PDO
 */
try {
    $db = new PDO(MARIA_DSN, DB_LOGIN, DB_PWD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erreur de connexion à la base de donnée : " . $e->getMessage());
}

/*
 * Si le formulaire a été soumis (PRG : Post/Redirect/Get)
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset(
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['usermail'],
        $_POST['phone'],
        $_POST['postcode'],
        $_POST['message']
    )
) {
    $insert = addGuestbook(
        $db,
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['usermail'],
        $_POST['phone'],
        $_POST['postcode'],
        $_POST['message']
    );

    // Redirection pour éviter le renvoi du formulaire au refresh
    header("Location: ?msg=" . ($insert ? 'success' : 'error'));
    exit;
}

// Messages de feedback (après redirection, on est en GET)
$successMessage = isset($_GET['msg']) && $_GET['msg'] === 'success';
$errorMessage   = isset($_GET['msg']) && $_GET['msg'] === 'error';

// Pagination
$pageActu = (isset($_GET[PAGINATION_GET]) && ctype_digit($_GET[PAGINATION_GET]))
    ? (int) $_GET[PAGINATION_GET]
    : 1;

if ($pageActu < 1) $pageActu = 1;

$nbEntries = getNbTotalGuestbook($db);
$nbPages   = ($nbEntries > 0) ? (int) ceil($nbEntries / PAGINATION_NB) : 1;

if ($pageActu > $nbPages) $pageActu = $nbPages;

$entries = getGuestbookPagination($db, $pageActu);

// Appel de la vue
include URL_BASE . "/view/guestbookView.php";

// Fermeture de la connexion
$db = null;