<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class TubeGuesserController extends AbstractController
{
    public function __invoke(): Response
    {
        // TODO

        return $this->render('');
    }
}
