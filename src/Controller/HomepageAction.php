<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class HomepageAction extends AbstractController
{
    const ROUTE_HOMEPAGE = 'app_homepage';

    #[Route('/', name: self::ROUTE_HOMEPAGE, methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('homepage.html.twig', [
            'pageTitle' => 'Bienvenue',
        ]);
    }
}
