<?php
# public/index.php


/*
 * Front Controller de la gestion du livre d'or
 */

/*
 * Chargement des dépendances
 */
// chargement de configuration
require_once "../config.php";
// chargement du modèle de la table guestbook
require_once URL_BASE . "/model/guestbookModel.php";

/*
 * Connexion à la base de données en utilisant PDO
 * Avec un try catch pour gérer les erreurs de connexion
 * Utilisez les constantes de config.php
 * Activez le mode d'erreur de PDO à Exception et
 * le mode fetch à tableau associatif
 */

try{
    $db = new PDO(MARIA_DSN, DB_LOGIN, DB_PWD);
} catch (Exception $e) {
    die("Erreur de connexion à la base de donnée : " . $e->getMessage());
}

$successMessage = false; 
$errorMessage = false; 

/*
 * Si le formulaire a été soumis
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
) 
// on appelle la fonction d'insertion dans la DB (addGuestbook())
{
    $insert = addGuestbook(
        $db, 
        $_POST['firstname'], 
        $_POST['lastname'], 
        $_POST['usermail'], 
        $_POST['phone'], 
        $_POST['postcode'], 
        $_POST['message'] 
    );

    if ($insert){
        $successMessage = true; 
    } else {
        $errorMessage = true; 
    }
}


$entries = getAllGuestbook($db);
$nbEntries = getNbTotalGuestbook($db); 

$pageActu = (isset($_GET[PAGINATION_GET]) && ctype_digit($_GET[PAGINATION_GET]))
    ? (int) $_GET[PAGINATION_GET]
    : 1;

if ($pageActu < 1) $pageActu = 1;

// Nombre total de messages (pour calculer le nb de pages)
$nbEntries = getNbTotalGuestbook($db);

// Nombre de pages total
$nbPages = ($nbEntries > 0) ? (int) ceil($nbEntries / PAGINATION_NB) : 1;

// Sécurité : si la page demandée dépasse le max
if ($pageActu > $nbPages) $pageActu = $nbPages;

// Messages de la page courante uniquement
$entries = getGuestbookPagination($db, $pageActu);


// Appel de la vue

include URL_BASE . "/view/guestbookView.php";

// fermeture de la connexion (bonne pratique)
$db = null;