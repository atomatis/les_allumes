<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class UserErrorSubscriberEvent implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ){}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event): void
    {
        $httpException = $event->getThrowable();

        if (
            !$httpException instanceof HttpExceptionInterface ||
            $httpException->getStatusCode() < 400 ||
            $httpException->getStatusCode() >= 500
        ) {return;}

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_error_bad_request', ['http_code' => $httpException->getStatusCode()])));
    }
}
