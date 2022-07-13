<?php

namespace App\DataFixtures;

use App\Entity\Gestionnaire;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\GestionnaireFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionnaireFixtures extends Fixture
{
    private $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;

    }
    public function load(ObjectManager $manager): void
    {
         for ($i = 1; $i < 10; $i++) {
            $gestionnaire = new Gestionnaire();
            $gestionnaire->setNomComplet('Selle'.$i);
            $gestionnaire->setEmail('Selle'.$i.'@gmail.com');
            $gestionnaire->setRoles(['ROLE_Gestionnaire']);
            $gestionnaire->setEtat('1');
            $gestionnaire->setPassword($this->passwordHasher->hashPassword( $gestionnaire,'passer'.$i));
            // $product->setPrice(mt_rand(10, 100));
           
            $manager->persist($gestionnaire);

    }
    $manager->flush();
}
}
