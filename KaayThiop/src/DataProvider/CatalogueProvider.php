<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Burger;
use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

Class CatalogueProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(BurgerRepository $repoBurger,MenuRepository $menuRepo){
        $this->repoBurger = $repoBurger;
        $this->menuRepo =$menuRepo;

    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;

    }

    public function getCollection(string $aresourceClass, string $operationName = null, array $context = []): iterable
    {
        // Retrieve the blog post collection from somewhere
        
        $tabcatalogue=[];
       $tabcatalogue['menu']=$this->menuRepo->findAll();
        $tabcatalogue['burger']= $this->repoBurger->findAll();
        return $tabcatalogue;
        // yield new BlogPost(1);
        // yield new BlogPost(2);
    }
}