<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class BadRequestController extends AbstractController
{
    #[Route('/bad_request_error', name:'app_error_bad_request', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        return $this->render('user_error/bad_request.html.twig', [
            'http_code' => $request->get('http_code'),
        ]);
    }
}
