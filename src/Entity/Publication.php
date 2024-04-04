<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM; 
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
#[Vich\Uploadable]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 5)]
    #[Assert\NotBlank()]
    private ?string $titre = null;

    #[Assert\Length(min: 5)]
    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $texte = null;

    #[Vich\UploadableField(mapping: 'publications_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null; 

    #[Assert\NotNull()]
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt;

    #[Assert\NotNull()]
    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull()]
    private ?User $idU = null;

    public function __construct() 
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int                               { return $this->id; }
    public function getTitre(): ?string                         { return $this->titre; }
    public function getTexte(): ?string                         { return $this->texte;}
    public function getImageFile(): ?File                       { return $this->imageFile;}
    public function getImageName(): ?string                     { return $this->imageName;}
    public function getIdU(): ?user                             { return $this->idU; }  
    public function getCreatedAt(): ?\DateTimeImmutable         { return $this->createdAt; }
    
    public function setTitre(string $titre): static             { $this->titre = $titre; return $this; }
    public function setTexte(string $texte): static             { $this->texte = $texte; return $this; }
    public function setIdU(?user $idU): static                  { $this->idU = $idU; return $this; }
    public function setCreatedAt(\DateTimeImmutable $date)      { $this->createdAt = $date; return $this; }
    public function setImageName(?string $imageName): void      { $this->imageName = $imageName; }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) 
        {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }


   
}
