<?php

namespace controllers;

use utils\Template;
use utils\SessionHelpers;
use models\EmprunterModel;
use models\RessourceModel;
use models\ExemplaireModel;
use controllers\base\WebController;

class CatalogueController extends WebController
{

    private RessourceModel $ressourceModel;
    private ExemplaireModel $exemplaireModel;
    private EmprunterModel $emprunter;

    function __construct()
    {
        $this->ressourceModel = new RessourceModel();
        $this->exemplaireModel = new ExemplaireModel();
        $this->emprunter = new EmprunterModel();
    }

    /**
     * Affiche la liste des ressources.
     * @param string $type
     * @return string
     */

    function liste(string $type): string
    {
        if ($type == "Tous") {
            // Récupération de l'ensemble du catalogue
            $catalogue = $this->ressourceModel->getAll();
        } else {
            // Récupération du catalogue par type
            $catalogue = $this->ressourceModel->getRessourcesByType($type);
        }

        switch ($type) {
            case 1:
                $type = "Livres";
                break;

            case 2:
                $type = "BD";
                break;

            case 3:
                $type = "Mangas";
                break;

            case 4:
                $type = "Comics";
                break;

            case 5:
                $type = "CD";
                break;

            case 6:
                $type = "Vinyles";
                break;

            case 7:
                $type = "DVD";
                break;

            case 8:
                $type = "Blu-Ray";
                break;

            case 9:
                $type = "Jeux vidéo";
                break;

            case 10:
                $type = "Jeux de société";
                break;

            case 11:
                $type = "Jeux de rôle";
                break;

            case 12:
                $type = "Jeux de cartes";
                break;

            case 13:
                $type = "Jeux de plateau";
                break;

            case 14:
                $type = "Jeux de figurines";
                break;

            case 15:
                $type = "Jeux de construction";
                break;

            case 16:
                $type = "Jeux de réflexion";
                break;

            case 17:
                $type = "Jeux de stratégie";
                break;

            case 18:
                $type = "Jeux de simulation";
                break;
                
            default:
                $type = "Tous";
                break;
        }

        // Affichage de la page à l'utilisateur
        $categories = $this->ressourceModel->getCategories();
        return Template::render("views/catalogue/liste.php", array("titre" => "Ensemble du catalogue \"" . $type . "\"", "catalogue" => $catalogue, "categories" => $categories));
    }

    /**
     * Affiche le détail d'une ressource.
     * @param int $id
     * @return string
     */

    function detail(int $id): string
    {
        // Récupération de l'id de l'utilisateur connecté
        $idEmprunteur = SessionHelpers::getConnected()->idemprunteur;

        // Récupération de la ressource
        $ressource = $this->ressourceModel->getOne($id);

        if ($ressource == null) {
            $this->redirect("/");
        }

        // Récupération des exemplaires de la ressource
        $exemplaires = $this->exemplaireModel->getByRessource($id);

        // Récupération des auteurs de la ressource

        // Si on en trouve plusieurs, on prend le premier.
        if ($exemplaires && sizeof($exemplaires) > 0) {
            $exemplaire = $exemplaires[0];
        }

        // Récupération des auteurs de la ressource
        $auteurs = $this->ressourceModel->getAuteurs($id);

        // Récupère les commentaires de la ressource
        $commentaires = $this->ressourceModel->getCommentaires($id);

        // Récupère les emprunts de l'utilisateur
        $emprunts = $this->emprunter->getEmprunts($idEmprunteur);

        return Template::render("views/catalogue/detail.php", array("ressource" => $ressource, "exemplaire" => $exemplaire, "auteurs" => $auteurs, "commentaires" => $commentaires, "emprunts" => $emprunts));
    }

    function commenter(int $id, int $note, string $commentaire): string
    {
        $idEmprunteur = SessionHelpers::getConnected()->idemprunteur;
        $this->ressourceModel->commenter($id, $note, $commentaire, $idEmprunteur);
        return $this->redirect("/catalogue/detail/" . $id);
    }
}