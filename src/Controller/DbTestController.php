<?php

namespace App\Controller;


use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use App\Repository\AuteurRepository;
use App\Repository\EmpruntRepository;
use App\Repository\EmprunteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DbTestController extends AbstractController
{ 
    #[Route('/db/test/users', name: 'app_db_test_users')]
    public function users(ManagerRegistry $doctrine): Response
    {
// - Affiche la liste complète de tous les utilisateurs de la table `user`
        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();
        dump($users);

// - Affiche les données de l'utilisateur dont l'id est `1`
        $users = $repository->find(1);
        dump($users);

// - Affiche les données de l'utilisateur dont l'email est `foo.foo@example.com`
        $users = $repository->findByEmail('foo.foo@example.com');
        dump($users);

// - Affiche les données des utilisateurs dont l'attribut `roles` 
//   contient le mot clé `ROLE_EMRUNTEUR`
        $users = $repository->findByRole('ROLE_EMPRUNTEUR');
        dump($users);

        exit();
    }


    #[Route('/db/test/livres', name: 'app_db_test_livres')]
    public function livres(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Livre::class);

//- la liste complète de tous les livres
        
        $livres = $repository->findAll();
        dump($livres);

 // - les données du livre dont l'id est `1`
        $livres = $repository->find(1);
        dump($livres);

//- la liste des livres dont le titre contient le mot clé `lorem`
        $livres = $repository->findByKeyword('lorem');
        dump($livres);

// //- la liste des livres dont l'id de l'auteur est `2`
        $id = 2;
        $livres = $repository->find($id);
        dump($livres);

// //- la liste des livres dont le genre contient le mot clé `roman`

$livres = $repository->findByKeywordGenre('roman');

        foreach ($livres as $livre) {
            dump($livre);

            $genres = $livre->getGenres();

            foreach ($genres as $genre) {
                dump($genre);
            }
        }

        exit();
    }
}


