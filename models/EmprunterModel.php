<?php

namespace models;

use models\base\SQL;

class EmprunterModel extends SQL
{
    public function __construct()
    {
        parent::__construct('emprunter', 'idemprunter');
    }

    /**
     * Déclare un emprunt dans la base de données.
     * @param $idRessource identifiant de la ressource empruntée (idressource)
     * @param $idExemplaire identifiant de l'exemplaire emprunté (idexemplaire)
     * @param $idemprunteur identifiant de l'emprunteur (lecteur)
     * @return bool true si l'emprunt a été déclaré, false sinon.
     */

    public function declarerEmprunt($idRessource, $idExemplaire, $idemprunteur): bool
    {
        try {
            $sql = 'INSERT INTO emprunter (idressource, idexemplaire, idemprunteur, datedebutemprunt, dureeemprunt, dateretour) VALUES (?, ?, ?, NOW(), 30, DATE_ADD(NOW(), INTERVAL 1 MONTH))';
            $stmt = parent::getPdo()->prepare($sql);
            $result = $stmt->execute([$idRessource, $idExemplaire, $idemprunteur]);
            return $result;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Récupère les emprunts d'un emprunteur en fonction de son id (idemprunteur)
     * @param $idemprunteur
     * @return array
     */
    public function getEmprunts($idemprunteur): array
    {
        try {
            $sql = 'SELECT * FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE idemprunteur = ? AND dateretourfait = 0';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return array();
        }
    }

    /**
     * Récupère l'emprunt le plus récent d'un emprunteur en fonction de son id (idemprunteur)
     * @param $idemprunteur
     * @return array
     */
    public function getLastEmprunts($idemprunteur): array
    {
        try {
            $sql = 'SELECT * FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE idemprunteur = ? AND dateretourfait = 0 ORDER BY datedebutemprunt DESC LIMIT 1';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$idemprunteur]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            return array();
        }
    }

    /**
     * Retourne les 5 ressources les plus empruntées.
     * @return array|false
     */
    public function getTopEmprunts(): array
    {
        try {
            $sql = 'SELECT COUNT(emprunter.idressource) AS nbEmprunt, titre, emprunter.idressource FROM emprunter LEFT JOIN ressource ON emprunter.idressource = ressource.idressource GROUP BY emprunter.idressource ORDER BY nbEmprunt DESC LIMIT 5';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }
}