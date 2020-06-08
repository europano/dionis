<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Page;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
/**
 * @Route("/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="document_index", methods={"GET"})
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="document_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $document = new Document(); 
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

             /** @var Document $document */
             $document = $form->getData();

             /** @var UploadedFile $file */
             $file = $document->getFichier();
             $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $originalName = $file->getClientOriginalName();
          try {
             $file->move( '../uploads', $fileName);
          } catch (FileException $e) {
             // ... gérer l'exception si quelque chose se produit pendant le téléchargement du fichier
          }
          
            $document->setOriginalDocument($fileName);
            $document ->setTitre($originalName);
            $entityManager->persist($document);
            $entityManager->flush();
            $this->addFlash('success', "Votre fichier a été uploadé ");
            return $this->redirectToRoute('document_index');

            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/new.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Document $document): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
           
            $entityManager = $this->getDoctrine()->getManager();
            $document->setPage(null);
            $entityManager->remove($document);
            $entityManager->flush();
         
        

        return $this->redirectToRoute('document_index');
          }
    }
       /**
     * @Route("/admin/document/download/{id}", name="document.upload")
     * @return BinaryFileResponse
     */
    public function downloadAction($uploadDir, Document $document)
    {
        $file = $uploadDir.$document->getOriginalDocument(); // Path to the file on the server

        return $this->file($file, $document->getTitre());
    }
}

