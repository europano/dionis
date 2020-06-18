<?php

namespace App\BusinessService;

use App\Entity\Categorie;
use App\Entity\Page;
use App\Repository\PageRepository;

class ArborescenceBS
{
    /**
     * @var array
     */
    private $arbre = [];

    /**
     * @var PageRepository
     */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Création de l'arbre des page
     *
     * @return array
     */
    public function arbre()
    {
        $this->arbre = [];

        // Récupération des pages sans page parent (j'ai modifié le formulaire pour rendre la page parent optionnelle.)
        $pagesSansParent = $this->pageRepository->findPagesSansParent();

        // On boucle sur les pages top niveau
        foreach ($pagesSansParent as $page) {
            $this->branche($page, $page->getCategorie());
        }

        return $this->arbre;
    }

    /**
     * On explore une branche. Cette méthode est récursive. Elle s'appelle elle-même. Elle parcoure tout l'arbre de page en page.
     *
     * @param Page $page
     * @param $niveau
     */
    private function branche(Page $page, Categorie $categorie = null, $niveau = 0): void
    {
        $this->arbre[] = [
            'niveau' => $niveau,
            'categorie' => $categorie,
            'page'   => $page,
        ];

        // On parcoure les pages enfants de la page courante
        foreach ($page->getEnfants() as $pageEnfant) {

            // Pour chaque page enfant, on va également parcourir les sous pages.
            $this->branche($pageEnfant, $categorie, $niveau + 1);
        }
    }
}
