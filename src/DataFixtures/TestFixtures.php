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


class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');

        $this->loadAuteurs($manager, $faker);
        $this->loadUsers($manager, $faker);
        // $this->loadLivres($manager, $faker);
        
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



//PROBLEME ENABLED CANNOT BE NULL
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

        $manager->flush();
    }


    // public function loadLivres(ObjectManager $manager, FakerGenerator $faker): void
    // {
    //     $livreDatas = [
    //         [
    //             'titre' => 'Lorem ipsum dolor sit amet',
    //             'annee_edition' => '2010',
    //             'nombre_pages' => '100',
    //             'code_isbn' => '9785786930024',
    //         ],
        

    //     ];

    //     foreach ($livreDatas as $livreData) {
    //         $livre = new Livre();
    //         $livre->setTitre($livreData['titre']);
    //         $livre->setAnneeEdition($livreData['annee_edition']);
    //         $livre->setNombrePages($livreData['nombre_pages']);
    //         $livre->setCodeIsbn($livreData['code_isbn']);
        

    //         $manager->persist($livre);
    //     }

    //     // for ($i = 0; $i < 500; $i++) {
    //     //     $auteur = new Auteur();
    //     //     $auteur->setNom($faker->lastName);
    //     //     $auteur->setPrenom($faker->firstName);

    //     //     $manager->persist($auteur);
    //     // }

    //     $manager->flush();
    // }

}
