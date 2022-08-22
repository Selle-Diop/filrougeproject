<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\TailleRepository;
use App\Repository\BoissonRepository;
use App\Repository\PortionFritesRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

Class ComplementProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(PortionFritesRepository $portions,TailleRepository $boisson){
        $this->portions = $portions;
        $this->boisson =$boisson;

    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;

    }

    public function getCollection(string $aresourceClass, string $operationName = null, array $context = []): iterable
    {
        // Retrieve the blog post collection from somewhere
        
        $tabcomplement=[];
       $tabcomplement['portion']=$this->portions->findAll();
        $tabcomplement['taille']= $this->boisson->findAll();
        return  $tabcomplement;
        // yield new BlogPost(1);
        // yield new BlogPost(2);
    }
}