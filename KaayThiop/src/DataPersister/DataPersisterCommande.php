<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;


use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class DataPersisterCommande implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $prix=0;


    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->_entityManager = $entityManager;
    

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande;
    }

    /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    {  
        
        if ($data instanceof Commande){
           
            foreach ($data->getLigneCommandes() as $ligne) 
            {
            $this->prix = $ligne->getProduit()->getPrix()*($ligne->getQuantite());
            $ligne->setPrix($this->prix);
            }
            // dd($this->prix);
            
        
        }
            $data->setNumCommande("NUM".date("Y-m-d H:i:s"));
                // $data->eraseCredentials();

        
       
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();


    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}