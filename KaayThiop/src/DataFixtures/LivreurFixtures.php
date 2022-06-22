<?php

namespace App\DataFixtures;

use App\Entity\Livreur;
use App\DataFixtures\LivreurFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class LivreurFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;

    }
    public function load(ObjectManager $manager): void
    {
       for ($i = 1; $i < 10; $i++) {
            $livreur = new Livreur();
            $livreur->setNomComplet('NdiayeLivreur'.$i);
            $livreur->setEmail('NdiayeLivreur'.$i.'@gmail.com');
            $livreur->setRoles(['Livreur']);
            $matricule='MAT-'.date('dmYhis');
            $livreur->setMatricule($matricule);

            $livreur->setEtat('1');
            $livreur->setPassword($this->passwordHasher->hashPassword( $livreur,'livreur'.$i));
            // $product->setPrice(mt_rand(10, 100));
           
            $manager->persist($livreur);

    }

        $manager->flush();
    }
}
