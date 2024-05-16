<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;


class MovieController extends AbstractController
{
    #[Route('/movie/{index}', name: 'app_movie')]
    public function Movie(EntityManagerInterface $entityManager, int $index): Response
    {
        $movie = $entityManager->getRepository(Movie::class)->find($index);

        if (!$movie) {
            throw $this->createNotFoundException(
                'No movie found for id ' . $index
            );
        }

        return $this->render('movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'title' => $movie->getTitle(),
            'description' => $movie->getDescription(),
            'image' => $movie->getImage(),
            'year' => $movie->getYear(),

        ]);
    }




    #[Route('/movieRecord', name: 'create_product')]
    public function createMovie(EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $movie->setTitle('Bidule');
        $movie->setYear(1999);
        $movie->setDescription('Ergonomic and stylish!');
        $movie->setImage('https://www.intelligence-artificielle-school.com/wp-content/uploads/2022/11/718285-avatar-2-a-enfin-sa-date-de-sortie-en-france-1-1368x513.jpeg');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($movie);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $movie->getId());
    }
}
