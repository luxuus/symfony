<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'genre')]
    private Collection $genre;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Movie $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
            $genre->addGenre($this);
        }

        return $this;
    }

    public function removeGenre(Movie $genre): static
    {
        if ($this->genre->removeElement($genre)) {
            $genre->removeGenre($this);
        }

        return $this;
    }
}
