<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $poster = null;

    #[Assert\Country]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $country = null;


    #[Assert\NotBlank]
    #[ORM\Column]
    private ?\DateTimeImmutable $releasedAt = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 255,
        minMessage: 'Le synopsis doit être d\'au moins 10 caractères',
        maxMessage: 'Le synopsis ne doit pas d\'être de plus de 255 caractères'
    )]
    #[ORM\Column(length: 255)]
    private ?string $plot = null;

    #[Assert\GreaterThan(
        value: 10,
        message: 'Le prix du billet ne peut pas être inférieur à 10€.'
    )]
    #[Assert\NotBlank]
    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'genre')]
    private Collection $genre;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $rated = null;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeImmutable $releasedAt): static
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): static
    {
        $this->plot = $plot;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genre->removeElement($genre);

        return $this;
    }

    public function getRated(): ?string
    {
        return $this->rated;
    }

    public function setRated(?string $rated): static
    {
        $this->rated = $rated;

        return $this;
    }

}
