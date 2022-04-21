<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToOne(inversedBy: 'candidature', targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $candidat;

    #[ORM\Column(type: 'string', length: 255)]
    private $photoCandidatPath;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCandidat(): ?User
    {
        return $this->candidat;
    }

    public function setCandidat(User $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getPhotoCandidatPath(): ?string
    {
        return $this->photoCandidatPath;
    }

    public function setPhotoCandidatPath(string $photoCandidatPath): self
    {
        $this->photoCandidatPath = $photoCandidatPath;

        return $this;
    }
}
