<?php

namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Menu2Controller extends AbstractController
{
    // #[Route('/menu2', name: 'app_menu2')]
    // public function index(): Response
    // {
    //     return $this->render('menu2/index.html.twig', [
    //         'controller_name' => 'Menu2Controller',
    //     ]);
    // }
public function __invoke(Request $request,
ValidatorInterface $validator,
TokenStorageInterface $tokenStorage,
SerializerInterface $serializer,
EntityManagerInterface $entityManager): JsonResponse
{
 $menu2 = $serializer->deserialize($request->getContent(),Menu::class,'json');
 $menu1=new Menu();
//  $errors = $validator->validate($menu2);
//  dd('pk');
//    if (count($errors) > 0) {
//        $errorsString =$serializer->serialize($errors,"json");
//     return new JsonResponse( $errorsString,Response::HTTP_BAD_REQUEST,[],true);
//     }
    dd(($menu2->getMenuBurgers())); 
    $menu2->setGestionnaire($tokenStorage->getToken()->getUser());
    $menu2->setPrix(12);
     $entityManager->persist($menu2);
     $entityManager->flush();
    $result =$serializer->serialize([
    'code'=>Response::HTTP_CREATED,
     'data'=>$menu2
   ],"json",[
    "groups"=>["all"]
   ]);
   return new JsonResponse($result ,Response::HTTP_CREATED,[],true);

    
}



}
