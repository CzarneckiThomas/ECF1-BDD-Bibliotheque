<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DbTestController extends AbstractController
{
    #[Route('/db/test', name: 'app_db_test')]
    public function index(): Response
    {
        // récupération du repository des auteurs
        $repository = $doctrine->getRepository(Auteur::class);
        // récupération de la liste complète de toutes les aurteurs
        $auteurs = $repository->findAll();
        // inspection de la liste
        dump($auteurs);

        // récupération du repository des emprunts
        $repository = $doctrine->getRepository(Emprunt::class);
        // récupération de la liste complète de toutes les emprunts
        $emprunts = $repository->findAll();
        // inspection de la liste
        dump($emprunts);

        // récupération du repository des emprunteurs
        $repository = $doctrine->getRepository(Emprunteur::class);
        // récupération de la liste complète de toutes les emprunteurs
        $emprunteurs = $repository->findAll();
        // inspection de la liste
        dump($emprunteurs);

        // récupération du repository des genres
        $repository = $doctrine->getRepository(Genre::class);
        // récupération de la liste complète de toutes les genres
        $genres = $repository->findAll();
        // inspection de la liste
        dump($genres);

        // récupération du repository des livres
        $repository = $doctrine->getRepository(Livre::class);
        // récupération de la liste complète de toutes les livres
        $livres = $repository->findAll();
        // inspection de la liste
        dump($livres);

        // récupération du repository des users
        $repository = $doctrine->getRepository(User::class);
        // récupération de la liste complète de toutes les users
        $users = $repository->findAll();
        // inspection de la liste
        dump($users);
    }
}
