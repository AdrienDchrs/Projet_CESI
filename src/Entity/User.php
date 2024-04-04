<?php

namespace App\Entity;

use App\Repository\UserRepository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
//Pour les passwords hashés
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(min: 3, max:50)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\Length(min: 3, max:50)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    
    //Pour les mails je donne pas de limite minimale on vérifiera le contenu du champ en WEB
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max:255)]
    #[Assert\Email( message: 'L\'adresse email saisie {{ value }} n\'est pas valide !',)]
    #[Assert\NotBlank()]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(min:8)]
    #[Assert\NotBlank()]
    private ?string $password = 'password';

    private ?string $plainPassword = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotNull()]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'idU', targetEntity: Publication::class)]
    private Collection $publications;

    public function __construct()
    {
        $this->publications = new ArrayCollection();
    }

    public function getId(): ?int               { return $this->id; }
    public function getNom(): ?string           { return $this->nom; }
    public function getPrenom(): ?string        { return $this->prenom; }
    public function getEmail(): ?string         { return $this->email; }
    public function getPassword(): ?string      { return $this->password; }
    public function getPlainPassword(): ?string { return $this->plainPassword; }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // garantit que chaque utilisateur possède le rôle ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setNom(string $nom): static                     { $this->nom = $nom; return $this; }
    public function setPrenom(string $prenom): static               { $this->prenom = $prenom; return $this; }
    public function setEmail(string $email): static                 { $this->email = $email; return $this;}
    public function setPassword(string $password): static           { $this->password = $password; return $this; }
    public function setPlainPassword(string $plainPassword): static { $this->plainPassword = $plainPassword; return $this; }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function addPublication(Publication $publication): static
    {
        if (!$this->publications->contains($publication)) {
            $this->publications->add($publication);
            $publication->setIdU($this);
        }

        return $this;
    }

    public function removePublication(Publication $publication): static
    {
        if ($this->publications->removeElement($publication)) {
            // set the owning side to null (unless already changed)
            if ($publication->getIdU() === $this) {
                $publication->setIdU(null);
            }
        }

        return $this;
    }

    // Méthodes abstraites de UserInsterface
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials()
    {
        //$this->plainPassword = null;
    }
    
}
