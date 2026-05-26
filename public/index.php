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

/*********************
 * Ou Bonus Pagination
 *********************/

// on vérifie sur quelle page on est (et que c'est un string qui contient que des numériques sans "." ni "-" => ctype_digit) en utilisant la variable $_GET et les constantes de config.php

# on compte le nombre total de messages (SQL)

# on récupère la pagination

# pour obtenir le $offset pour les messages (calcul)

# on veut récupérer les messages de la page courante

/**************************
 * Fin du Bonus Pagination
 **************************/

// Appel de la vue

include URL_BASE . "/view/guestbookView.php";

// fermeture de la connexion (bonne pratique)