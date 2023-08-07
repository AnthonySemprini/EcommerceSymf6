<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileCrontrollerController extends AbstractController
{
    #[Route('/profile/crontroller', name: 'app_profile_crontroller')]
    public function index(): Response
    {
        return $this->render('profile_crontroller/index.html.twig', [
            'controller_name' => 'ProfileCrontrollerController',
        ]);
    }
}
