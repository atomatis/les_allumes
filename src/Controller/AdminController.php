<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class AdminController extends AbstractController
{
    const ROUTE_DASHBOARD = 'app_admin_dashboard';

    #[Route('/admin/dashboard', name: self::ROUTE_DASHBOARD)]
    public function __invoke(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'pageTitle' => 'Admin',
            'backRouteName' => 'app_homepage',
        ]);
    }
}
