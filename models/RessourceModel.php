<?php
namespace models;

use models\base\SQL;

class RessourceModel extends SQL
{
    public function __construct()
    {
        parent::__construct('ressource', 'idressource');
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getLastedRessources(): array
    {
        // Affiche les nouveauté donc plus l'ID est haut plus il est récent
        $sql = 'SELECT * FROM ressource INNER JOIN categorie ON ressource.idcategorie = categorie.idcategorie ORDER BY idressource DESC LIMIT 6;';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRandomRessource($limit = 3)
    {
        $sql = 'SELECT * FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie  ORDER BY RAND() LIMIT ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getCategories(): array
    {
        $sql = 'SELECT * FROM categorie';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getRessourcesByType(string $type): array
    {
        $sql = 'SELECT * FROM ressource LEFT JOIN categorie ON categorie.idcategorie = ressource.idcategorie WHERE categorie.idcategorie = ?';
        $stmt = parent::getPdo()->prepare($sql);
        $stmt->execute([$type]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function commenter(int $id, int $note, string $commentaire, int $idEmprunteur): bool
    {
        try {
            $sql = 'INSERT INTO commentaire (contenu, note, idressource, idutilisateur, dateCreation) VALUES (?, ?, ?, ?, NOW());';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$commentaire, $note, $id, $idEmprunteur]);
            return true;
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public function getAuteurs(int $id): bool|array
    {
        try {
            $sql = 'SELECT * FROM auteur a INNER JOIN auteur_ressource ar ON a.idauteur = ar.idauteur WHERE ar.idressource = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public function getCommentaires(int $id): bool|array
    {
        try {
            $sql = 'SELECT * FROM commentaire c INNER JOIN emprunteur u ON c.idutilisateur = u.idemprunteur WHERE c.idressource = ?';
            $stmt = parent::getPdo()->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
}