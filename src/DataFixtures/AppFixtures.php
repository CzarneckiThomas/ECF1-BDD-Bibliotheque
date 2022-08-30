<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
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

        $this->loadAuteurs($manager);
        $this->loadUsers($manager);
        $this->loadLivres($manager);
        $this->loadGenres($manager);
        $this->loadEmprunts($manager);

        
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

        
        $manager->flush();
    }


    public function loadUsers(ObjectManager $manager, FakerGenerator $faker): void
    {

        //Compte Administreur
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $password = $this->hasher->hashPassword($user, '123');
        $user->setPassword($password);
        $user->setEnabled(true);
        $user->setCreatedAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00'));
        $user->setUpdatedAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00'));

        $manager->persist($user);


        $emprunteurDatas = [
            
            [
                'nom' => 'foo',
                'prenom' => 'foo',
                'tel' => '123456789',
                'email' => 'foo.foo@example.com',
                'roles' => ['ROLE_EMRUNTEUR'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
            ],
            [
                'nom' => 'bar',
                'prenom' => 'bar',
                'tel' => '123456789',
                'email' => 'bar.bar@example.com',
                'roles' => ['ROLE_EMRUNTEUR'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'false',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 11:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 11:00:00'),
            ],
            [
                'nom' => 'baz',
                'prenom' => 'baz',
                'tel' => '123456789',
                'email' => 'baz.baz@example.com',
                'roles' => ['ROLE_EMRUNTEUR'],
                'password' => '$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K',
                'enabled' => 'true',
                'created_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 12:00:00'),
                'updated_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 12:00:00'),
            ],
            
        ];

        foreach ($emprunteurDatas as $emprunteurData) {
            $user = new User();
            $user->setEmail($emprunteurData['email']);
            $user->setRoles($emprunteurData['roles']);
            $password = $this->hasher->hashPassword($user, $emprunteurData['password']);
            $user->setPassword($password);
            $user->setEnabled($emprunteurData['enabled']);
            $user->setCreatedAt($emprunteurData['created_at']);
            $user->setUpdatedAt($emprunteurData['updated_at']);

            $manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur->setUser($user);
            $emprunteur->setNom($emprunteurData['nom']);
            $emprunteur->setPrenom($emprunteurData['prenom']);
            $emprunteur->setTel($emprunteurData['tel']);
            $emprunteur->setActif($emprunteurData['actif']);
            $emprunteur->setCreatedAt($emprunteurData['createdAt']);
            $emprunteur->setUpdatedAt($emprunteurData['updatedAt']);

            $manager->persist($emprunteur);
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

        $manager->flush();
    }

}