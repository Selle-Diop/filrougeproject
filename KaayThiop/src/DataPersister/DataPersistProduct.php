<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Entity\PortionFrites;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class DataPersistProduct implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $prix=0;


    public function __construct(
        EntityManagerInterface $entityManager,RequestStack  $requestStack
    ) {
        $this->_entityManager = $entityManager;
        $this->requestStack = $requestStack;

    

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
    }

    /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {  
        if ($data instanceof Boisson or $data instanceof PortionFrites){
            $data->setPrix(0);
        }elseif ($data instanceof Menu){
            
            foreach ($data->getMenuBurgers() as $MB) {
               $this->prix += $MB->getBurgers()->getPrix()*($MB->getQuantite());
                // dd($this->prix);
            }
            foreach ($data->getFriteBoissons() as $PF) {
            //  $prix+=$frite->getPrix();  
               $this->prix += $PF->getMenus()->getPrix()*($PF->getQuantite());

            }
             foreach ($data->getMenuTailles() as $MT) {
            //  $prix+=$boissons->getPrix();
                
               $this->prix +=$MT->getMenus()->getPrix()*($MT->getQuantite());

            }
            // $this->prix-=$this->prix*0.05;
            $data->setPrix($this->prix);
        }else{
            $data instanceof Burger;
            $image = stream_get_contents(fopen($data->getFile()->getRealPath(),"rb"));
            
            $data->setImage($image);

        }
    
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