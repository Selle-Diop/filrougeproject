<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class EmailValidateAction extends AbstractController{


public function  __construct (EntityManagerInterface $manager)
{
$this->manager =$manager;

}
public function  __invoke(Request $request,UserRepository $userR,EntityManagerInterface $manager)
{
    $tokens=$request->get('token');
   
   $userT= $userR->findOneBy(['token'=>$tokens]);
   if(!$userT){
       return new JsonResponse(['error' => 'token not found'],Response::HTTP_BAD_REQUEST);
   }
   if($userT->isIsEnable()){
       return new JsonResponse(['success' => 'compte deja activé'],Response::HTTP_BAD_REQUEST);

   }
    if($userT->getExpireAT()< new \DateTime()){
       return new JsonResponse(['message' => 'token expiré'],Response::HTTP_BAD_REQUEST);

   }
   $userT->setIsEnable(true);
   $manager->flush();
       return new JsonResponse(['message' => 'compte activé avec success'],Response::HTTP_OK);


}

}