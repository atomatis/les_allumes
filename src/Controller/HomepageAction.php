<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class HomepageAction extends AbstractController
{
    #[Route('/', name:'app_homepage', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function __invoke(): Response
    {
        return $this->render('homepage.html.twig');
    }
}
