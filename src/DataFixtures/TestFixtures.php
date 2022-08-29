<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\User;
use App\Entity\Livre;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher)
    {
        $this->doctrine = $doctrine;
        $this->hasher = $hasher;

    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');

        $this->loadAuteurs($manager, $faker);
        $this->loadUsers($manager, $faker);
        $this->loadLivres($manager, $faker);
        
    }
    
    public function loadAuteurs(ObjectManager $manager, FakerGenerator $faker): void
    {
        $auteurDatas = [
            [
                'nom' => 'Auteur inconnu',
                'prenom' => '',
            ],
            [
                'nom' => 'Cartier',
                'prenom' => 'Hugues',
            ],
            [
                'nom' => 'Lambert',
                'prenom' => 'Armand',
            ],
            [
                'nom' => 'Moitessier',
                'prenom' => 'Thomas',
            ],

        ];

        foreach ($auteurDatas as $auteurData) {
            $auteur = new Auteur();
            $auteur->setNom($auteurData['nom']);
            $auteur->setPrenom($auteurData['prenom']);
        

            $manager->persist($auteur);
        }

        for ($i = 0; $i < 500; $i++) {
            $auteur = new Auteur();
            $auteur->setNom($faker->lastName);
            $auteur->setPrenom($faker->firstName);

            $manager->persist($auteur);
        }

        $manager->flush();
    }


    public function loadUsers(ObjectManager $manager, FakerGenerator $faker): void
    {
        $userDatas = [
            [
                'email' => 'admin@example.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00'),
            ],
            [
                'email' => 'foo.foo@example.com',
                'roles' => ['ROLE_EMRUNTEUR'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
            ],
            [
                'email' => 'bar.bar@example.com',
                'roles' => ['ROLE_EMRUNTEUR'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'false',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 11:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 11:00:00'),
            ],
            [
                'email' => 'baz.baz@example.com',
                'roles' => ['ROLE_EMRUNTEUR'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 12:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 12:00:00'),
            ],
            
        ];

        foreach ($userDatas as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setPassword($userData['password']);
            $user->setEnabled($userData['enabled']);
            $user->setCreatedAt($userData['created_at']);
            $user->setUpdatedAt($userData['updated_at']);

            $manager->persist($user);
        }

        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $password = $this->hasher->hashPassword($user, '123');
            $user->setPassword($password);
            $user->setEnabled(true);
            $date = $faker->dateTimeThisYear();
            $date = DateTimeImmutable::createFromInterface($date);
            $user->setCreatedAt($date);
            $user->setUpdatedAt($date);
            

            $manager->persist($user);
        }

        $manager->flush();
    }


    public function loadLivres(ObjectManager $manager, FakerGenerator $faker): void
    {

        $repository = $this->doctrine->getRepository(Auteur::class);
        $auteurs = $repository->findAll();

        $repository = $this->doctrine->getRepository(Genre::class);
        $genres = $repository->findAll();

        $livreDatas = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'annee_edition' => 2010,
                'nombre_pages' => 100,
                'code_isbn' => '9785786930024',
                'auteur' => $auteurs[0],
                'genres' => [$genres[0]],
            ],
            [
                'titre' => 'Consectetur adipiscing elit',
                'annee_edition' => 2011,
                'nombre_pages' => 150,
                'code_isbn' => '9783817260935',
                'auteur' => $auteurs[1],
                'genres' => [$genres[1]],
            ],
            [
                'titre' => 'Mihi quidem Antiochum',
                'annee_edition' => 2012,
                'nombre_pages' => 200,
                'code_isbn' => '9782020493727',
                'auteur' => $auteurs[2],
                'genres' => [$genres[2]],
            ],
            [
                'titre' => 'Quem audis satis belle',
                'annee_edition' => 2013,
                'nombre_pages' => 250,
                'code_isbn' => '9794059561353',
                'auteur' => $auteurs[3],
                'genres' => [$genres[3]],
            ],
        

        ];

        foreach ($livreDatas as $livreData) {
            $livre = new Livre();
            $livre->setTitre($livreData['titre']);
            $livre->setAnneeEdition($livreData['annee_edition']);
            $livre->setNombrePages($livreData['nombre_pages']);
            $livre->setCodeIsbn($livreData['code_isbn']);
            $livre->setAuteur($livreData['auteur']);

            foreach ($livreData['genres'] as $genre) {
                $livre->addGenre($genre);
            }
        

            $manager->persist($livre);
        }

        for ($i = 0; $i < 1000; $i++) {
            $livre = new Livre();
            $livre->setTitre($faker->sentence($nbWords = 6, $variableNbWords = true));
            $livre->setAnneeEdition($faker->numberBetween(1987, 2022));
            $livre->setNombrePages($faker->numberBetween(150, 400));
            $livre->setCodeIsbn($faker->isbn10());
            
            $auteur = $faker->randomElement($auteurs);
            $livre->setAuteur($auteur);

            $genreRandoms = $faker->randomElements($genres);

            foreach ($genreRandoms as $genreRandom) {
                $livre->addGenre($genreRandom);
            }
            
            $manager->persist($livre);
        }

        $manager->flush();
    }

}
