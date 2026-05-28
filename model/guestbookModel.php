<?php
# model/guestbookModel.php
/********************************
 * Model de la page livre d'or
 *******************************/

// INSERTION d'un message dans le livre d'or

/**
 * @param PDO $db
 * @param string $firstname
 * @param string $lastname
 * @param string $usermail
 * @param string $phone
 * @param string $postcode
 * @param string $message
 * @return bool
 * Fonction qui insère un message dans la base de données 'ti2web2026' et sa table 'guestbook'
 * Renvoie true si l'insertion a réussi, false sinon
 * Une requête préparée est utilisée pour éviter les injections SQL
 * Les données sont échappées pour éviter les injections XSS (protection backend)
 */
function addGuestbook(PDO $db,
                    string $firstname,
                    string $lastname,
                    string $usermail,
                    string $phone,
                    string $postcode,
                    string $message
): bool
{
   $firstname = htmlspecialchars(trim(strip_tags($firstname)));
   if (empty($firstname) || strlen($firstname) > 100) return false;

   $lastname = htmlspecialchars(trim(strip_tags($lastname)));
   if (empty($lastname) || strlen($lastname) > 100) return false;

   $usermail = trim(strip_tags($usermail));
   if (empty($usermail) || strlen($usermail) > 200 || !filter_var($usermail, FILTER_VALIDATE_EMAIL)) return false;
   $usermail = htmlspecialchars($usermail);

   $phone = trim($phone);
    if (!preg_match('/^(\+32|0032|0)4\d{8}$/', $phone) || strlen($phone) > 20) return false;

    $postcode = trim($postcode);
    if (!preg_match('/^\d{4}$/', $postcode)) return false;

    $message = htmlspecialchars(trim(strip_tags($message)));
    if (empty($message) || strlen($message) > 500) return false;
    
    
    // requête préparée obligatoire !
try {
        $stmt = $db->prepare(
            "INSERT INTO `guestbook` (`firstname`, `lastname`, `usermail`, `phone`, `postcode`, `message`)
             VALUES (:firstname, :lastname, :usermail, :phone, :postcode, :message)"
        );

        
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':usermail', $usermail);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':postcode', $postcode);
        $stmt->bindValue(':message', $message);

        return $stmt-> execute(); 

    } catch (Exception $e){
        die("Erreur SQL AddGuestBook : " . $e->getMessage()); 
    }
    return false;
  }   

/***************************
 * Sans le Bonus Pagination
 **************************/

// SELECTION de messages dans le livre d'or par ordre de date croissante
/**
 * @param PDO $db
 * @return array
 * Fonction qui récupère tous les messages du livre d'or par ordre de date croissante
 * venant de la base de données 'ti2web2026' et de la table 'guestbook'
 * Si pas de message, renvoie un tableau vide
 */
function getAllGuestbook(PDO $db): array
{
       try {
        $stmt   = $db->query("SELECT * FROM `guestbook` ORDER BY `datemessage` DESC");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    } catch (Exception $e) {
        die("Erreur SQL getAllGuestbook : " . $e->getMessage());
    }
    return [];
}

/**************************
 * Pour le Bonus Pagination
 **************************/

// SELECTION du nombre total de messages
/**
 * @param PDO $db
 * @return int
 * Fonction qui compte le nombre total de messages dans la table 'guestbook'
 */
function getNbTotalGuestbook(PDO $db): int
{

     try {
        $stmt   = $db->query("SELECT COUNT(`id`) AS `nb` FROM `guestbook`");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return (int) $result['nb'];
    } catch (Exception $e) {
        die("Erreur SQL getNbTotalGuestbook : " . $e->getMessage());
    }
    return 0;

}
// SELECTION de messages dans le livre d'or par ordre de date croissante
// en lien avec la pagination
/**
 * @param PDO $db
 * @param int $pageActu = 1
 * @param int $limit = 3
 * @return array
 * Fonction qui récupère les messages du livre d'or par ordre de date croissante
 * venant de la base de données 'ti2web2026' et de la table 'guestbook'
 * en utilisant une requête préparée (injection SQL), n'affiche que les messages
 * de la page courante
 */
function getGuestbookPagination(PDO $db, int $pageActu=1, int $limit=3): array
{
    $offset = ($pageActu - 1) * PAGINATION_NB; 

    try{
        $stmt = $db->prepare(
           "SELECT * FROM `guestbook`
             ORDER BY `datemessage` DESC
             LIMIT :limit OFFSET :offset" 
        );

        $stmt->bindValue(':limit',  PAGINATION_NB, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,       PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $result;
    } catch (Exception $e) {
        die("Erreur SQL getGuestbookPagination : " . $e->getMessage());
    }
    return [];
}

# Pour afficher la pagination dans la vue
// FONCTION de pagination
/**
 * @param int $nbtotalMessage
 * @param string $url
 * @param string $get
 * @param int $pageActu
 * @param int $perPage
 * @return string
 * Fonction qui génère le code HTML de la pagination
 * si le nombre de pages est supérieur à une.
 */
function pagination(int $nbEntries, string $url="./?", string $get="pg", int $pageActu=1, int $perPage=3 ): string
{
    $sortie = "";
    if ($nbEntries === 0) return "";
    $nbPages = ceil($nbEntries / $perPage);
    if ($nbPages == 1) return "";
    $sortie .= "<p>";
    for ($i = 1; $i <= $nbPages; $i++) {
        if ($i === 1) {
            if ($pageActu === 1) {
                $sortie .= "<< < 1 |";
            } elseif ($pageActu === 2) {
                $sortie .= " <a href='$url'><<</a> <a href='$url'><</a> <a href='$url'>1</a> |";
            } else {
                $sortie .= " <a href='$url'><<</a> <a href='$url&$get=" . ($pageActu - 1) . "'><</a> <a href='$url'>1</a> |";
            }
        } elseif ($i < $nbPages) {
            if ($i === $pageActu) {
                $sortie .= "  $i |";
            } else {
                $sortie .= "  <a href='$url&$get=$i'>$i</a> |";
            }
        } else {
            if ($pageActu >= $nbPages) {
                $sortie .= "  $nbPages > >>";
            } else {
                $sortie .= "  <a href='$url&$get=$nbPages'>$nbPages</a> <a href='$url&$get=" . ($pageActu + 1) . "'>></a> <a href='$url&$get=$nbPages'>>></a>";
            }
        }
    }
    $sortie .= "</p>";
    return $sortie;

}