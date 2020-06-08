<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="documents")
     
     */
    private $page;

    /**
     * @var UploadedFile
    */
    private $fichier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $originalDocument;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }
    /**
     * @return UploadedFile
    */
    public function getFichier()
    {
        return $this->fichier;
    }
    
    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $fichier
    */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
        }

    public function getOriginalDocument(): ?string
    {
        return $this->originalDocument;
    }

    public function setOriginalDocument(string $originalDocument): self
    {
        $this->originalDocument = $originalDocument;

        return $this;
    }
    public function removeDocument(Document $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getPage() === $this) {
                $document->setPage(null);
            }

        }
        
        return $this;
    }

}


