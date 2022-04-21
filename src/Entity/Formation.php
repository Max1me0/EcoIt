<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: Leçon::class, orphanRemoval: true)]
    private $leçons;

    #[ORM\Column(type: 'string', length: 255)]
    private $imagePath;

    public function __construct()
    {
        $this->leçons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    /**
     * @return Collection<int, Leçon>
     */
    public function getLeçons(): Collection
    {
        return $this->leçons;
    }

    public function addLeOn(Leçon $leOn): self
    {
        if (!$this->leçons->contains($leOn)) {
            $this->leçons[] = $leOn;
            $leOn->setFormation($this);
        }

        return $this;
    }

    public function removeLeOn(Leçon $leOn): self
    {
        if ($this->leçons->removeElement($leOn)) {
            // set the owning side to null (unless already changed)
            if ($leOn->getFormation() === $this) {
                $leOn->setFormation(null);
            }
        }

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}
