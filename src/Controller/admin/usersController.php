<?php

namespace App\Controller\admin;


use Symfony\Component\HttpFoundation\Response;

use Symfony\component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/users', name: 'app_admin_users')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/users/index.html.twig');
    }



}