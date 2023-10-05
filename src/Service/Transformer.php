<?php

namespace App\Service;
use App\Entity\Genre;
use App\Entity\Movie;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class Transformer
{


    public function __construct(private OmdbApiConsumer $omdbApiConsumer, private EntityManagerInterface $entityManager)
    {

    }

    public function persist(string $name)
    {
        $content = $this->omdbApiConsumer->getByTitle($name);

        $movie = new Movie();
        $movie->setTitle($content['Title']);
        $date = new \DateTimeImmutable($content['Released']);
        $movie->setReleasedAt($date);
        $movie->setCountry($content['Country']);
        $movie->setPoster($content['Poster']);
        $movie->setPlot($content['Plot']);
        $movie->setRated($content['Rated']);
        $genres = explode(', ',$content['Genre']);
        foreach ($genres as $genre){
            $obj = new Genre();
            $obj->setName($genre);
            $movie->addGenre($obj);
        }

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

    }
}