<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackBundleController extends AbstractController
{

    /**
     * @Route("/back/bundle", name="back_bundle")
     */
    public function index(): Response
    {
        return $this->render('back_bundle/index1.html.twig', [
            'controller_name' => 'BackBundleController',
        ]);
    }
}
