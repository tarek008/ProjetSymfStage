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
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\File\File;




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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('back_bundle/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }



  /**
    *@Route("/user/bundle",name="user_index")
    */
  public function index(Request $request)
  {
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class,$propertySearch);
    $form->handleRequest($request);
   //initialement le tableau des users est vide, 
   //c.a.d on affiche les Users que lorsque l'utilisateur clique sur le bouton rechercher
    $users= [];
    
   if($form->isSubmitted() && $form->isValid()) {
   //on récupère le nom d'User tapé dans le formulaire
    $nom = $propertySearch->getNom();   
    if ($nom!="") 
      //si on a fourni un nom d'User on affiche tous les Users ayant ce nom
      $users= $this->getDoctrine()->getRepository(User::class)->findBy(['username' => $nom] );
    else   
      //si si aucun nom n'est fourni on affiche tous les Users
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

          
 /** @var UploadedFile $file */
 $file = $user->getImage();
 $filename= md5(uniqid()) . '.' . $file->guessExtension();
 $file->move($this->getParameter('photos_directory'), $filename);
 $user->setImage($filename);


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


      /**
     * @Route("/user/bundle/statistique", name="user_stats")
     */

    public function statistiques(Request $request ){
      $users= [];

      $users= $this->getDoctrine()->getRepository(User::class)->findAll();
 
      $categNom=[];

      foreach($users as $user){
        $categNom = $user->getRole();  
      }
      



      return $this->render('user_bundle/userstats.html.twig',[
        'categNom'=>json_encode($categNom),
      ]);
  }

}
