<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;


class UserBundleController extends AbstractController
{
   # /**
    # * @Route("/user/bundle", name="user_index" , methods={"GET"})
    # */
  #  public function index(): Response
  #  {
   #  $users = $this->getDoctrine()
    #        ->getRepository(User::class)
     #       ->findAll();

      #  return $this->render('user_bundle/ListCollaborateurs.html.twig', [
      #      'users' => $users,
      #  ]);
  #  }

  /**
    *@Route("/user/bundle",name="user_index")
    */
  public function index(Request $request)
  {
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class,$propertySearch);
    $form->handleRequest($request);
   //initialement le tableau des articles est vide, 
   //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
    $users= [];
    
   if($form->isSubmitted() && $form->isValid()) {
   //on récupère le nom d'article tapé dans le formulaire
    $nom = $propertySearch->getNom();   
    if ($nom!="") 
      //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
      $users= $this->getDoctrine()->getRepository(User::class)->findBy(['username' => $nom] );
    else   
      //si si aucun nom n'est fourni on affiche tous les articles
      $users= $this->getDoctrine()->getRepository(User::class)->findAll();
   }
    return  $this->render('user_bundle/ListCollaborateurs.html.twig',[ 'form' =>$form->createView(), 'users' => $users]);  
  }



















       /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user_bundle/show.html.twig', [
            'user' => $user,
        ]);
    }


  /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user_bundle/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



       /**
     * @Route("/user/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

}
