<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;


use App\Entity\Boisson;
use App\Entity\Livreur;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Repository\ClientRepository;
use App\Repository\LivreurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class DataPersisterCommande implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $prix=0;


    public function __construct(
        EntityManagerInterface $entityManager,
        ClientRepository $client,
        LivreurRepository $livreur
    ) {
        $this->_entityManager = $entityManager;
        $this->client = $client;
        $this->livreur = $livreur;



    

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande  OR $data instanceof Livraison;
    }

    /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    
    {   
        if($data instanceof Livraison){
            // $tr=$data->getLivreur();
            
            foreach ($data->getCommandes() as $commande){

               
                if($commande->isIsEnvoi()){
                
                    return new JsonResponse(["error" => "Ce commande est deja en cours de livraison"],Response::HTTP_BAD_REQUEST);
                    
                }else{
                    $commande->setIsEnvoi(true);
                    $commande->setIsEtatCommande('en cours de livraison');


                }
            }
        }
        
        if ($data instanceof Commande){
        //    dd($data->getLigneCommandes());
            foreach ($data->getLigneCommandes() as $ligne) 
            {
                if($ligne->getProduit() instanceof Boisson){
        
                 if($ligne->getQuantite() > $ligne->getProduit()->getStockboisson())
                 {
                    return new JsonResponse(["error" => "Boisson not available"],Response::HTTP_BAD_REQUEST);
                 }else{
                     
                $ligne->getProduit()->setStockboisson($ligne->getProduit()->getStockboisson()-$ligne->getQuantite());
                
               }
               
                    
                }

            $this->prix = $ligne->getProduit()->getPrix()*($ligne->getQuantite());
            $ligne->setPrix($this->prix);
            }
           
            // dd($this->prix);
            
        
        }
                

        
        $this->_entityManager->persist($data);
        // $tr->setisEtatLivreur('indisponible');
        // $this->_entityManager->persist($tr);


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