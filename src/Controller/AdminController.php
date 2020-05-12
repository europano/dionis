<?php

namespace App\Controller;
use App\Entity\Page;
use App\Form\PageType;
use App\Entity\Categorie;
use App\Entity\Fichier;
use App\Form\CategorieType;
use App\Form\FichierType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin/index", name="admin.page")
     *
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    //liste des pages
     public function page(Request $request, PaginatorInterface $paginator)
    {
        $repo=$this->getDoctrine() ->getRepository(Page::class);
        $pages = $paginator->paginate(
            $repo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            15 /*limit per page*/
        );

        return $this->render('admin/page.html.twig', [
            'controller_name' => 'AdminController',
        'pages'=>$pages
            ]);
    }

    /**
     * @Route("/admin/page/new", name="admin.form.page")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response

     */

    // création d'une nouvelle page
    public function pageForm (Request $request, EntityManagerInterface $manager)
    {
        $page =new Page();
        $categorie =new Categorie();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Page $page */
            $page = $form->getData();

            /** @var UploadedFile $file */
            $file = $page->getFichier();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move( '../uploads',   $fileName);

            $page->setCreatedAt(new \DateTime());
            $page->setJourAt(new \DateTime());

            $manager->persist($page);
            $manager->flush();
            return $this->redirectToRoute('admin.page',
            ['id'=>$page->getId()]); // Redirection vers la page
        }
        return $this->render('admin/pageform.html.twig', [
            'formPage' => $form->createView()
        ]);
    }

    /**
    * @Route("/admin/page/edit/{id}", name="admin.page.modif")
    * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    */
    //modifier une page
    public function pageModif(page $page, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if($form->isSubMitted() && $form->isValid()){
            /** @var Page $page */
            $page = $form->getData();

            /** @var UploadedFile $file */
            if(null !== $page->getFichier()){
                $file = $page->getFichier();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move( '../uploads',   $fileName);
            }

            $page->setJourAt(new \DateTime());
            $manager->persist($page);
            $manager->flush();

            return $this->redirectToRoute('admin.page',
            ['id'=>$page->getId()]);
        }
        return $this->render('admin/pagemodif.html.twig', [
               'formModifPage' => $form->createView()
               ]);
    }

    /**
    * @Route("/admin/page/delete/{id}", name="admin.page.sup")
         * @param Request $request
     * @param EntityManagerInterface $manager
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse

    */
    // supprimer une page
    public function pageSup($id, EntityManagerInterface $manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Page::class);
        $page = $repo->find($id);

        $manager->remove($page);
        $manager->flush();

        return $this->redirectToRoute('admin.page');
    }

    /**
     * @Route("/admin/categorie", name="admin.categorie")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
        // liste des catégories
    public function categorie(Request $request)
    {
        $repos=$this->getDoctrine() ->getRepository(Categorie::class);
        $categories=        $repos->findAll();

        return $this->render('admin/categorie.html.twig', [
            'controller_name' => 'AdminController',
        'categories'=>$categories
            ]);
    }

    /**
     * @Route("/admin/form/categorie", name="admin.form.categorie")
     *
          * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response

     */
// création d'une nouvelle catégorie
     public function categorieForm(Request $request, EntityManagerInterface $manager)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $manager->persist($categorie);
        $manager->flush();
        return $this->redirectToRoute('admin.categorie',
        ['id'=>$categorie->getId()]); // Redirection vers
        }
        return $this->render('admin/catform.html.twig', [
            'formCategorie' => $form->createView()
        ]);
    }

    /**
    * @Route("/admin/categorie/edit/{id}", name="admin.categorie.modif")
    *
    * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Categorie $categorie
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response

    */
    // modification de la catégorie
    public function modifCategorie(categorie $categorie, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubMitted() && $form->isValid()){
        $manager->persist($categorie);
        $manager->flush();

        return $this->redirectToRoute('admin.categorie',
        ['id'=>$categorie->getId()]);
        }
        return $this->render('admin/catmodif.html.twig', [
        'formModifCat' => $form->createView()
        ]);
    }

    /**
     * supprimer une catégorie
     *
     * @Route("/admin/categorie/delete/{id}", name="admin.categorie.sup")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
    */
    public function supCategorie($id, EntityManagerInterface $manager, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Categorie::class);
        $categorie = $repo->find($id);

        $manager->remove($categorie);
        $manager->flush();

        return $this->redirectToRoute('admin.categorie');
    }

    /**
     * détail affichage d'une seul page
     *
     * @Route("admin/show/{id}", name="admin.show")
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($id, Request $request)
    {
        $repo=$this->getDoctrine() ->getRepository(Page::class);
        $page=$repo->find($id);

        return $this->render('admin/show.html.twig', [
            'controller_name' => 'AdminController',
        'page'=>$page
            ]);
    }

}
