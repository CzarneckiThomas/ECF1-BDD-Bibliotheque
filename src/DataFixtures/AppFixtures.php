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