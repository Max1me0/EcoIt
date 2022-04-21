<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Leçon::class, orphanRemoval: true)]
    private $leçons;

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
            $leOn->setSection($this);
        }

        return $this;
    }

    public function removeLeOn(Leçon $leOn): self
    {
        if ($this->leçons->removeElement($leOn)) {
            // set the owning side to null (unless already changed)
            if ($leOn->getSection() === $this) {
                $leOn->setSection(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->getId();
    }
}
