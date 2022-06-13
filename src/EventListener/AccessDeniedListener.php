<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class AccessDeniedListener implements EventSubscriberInterface
{
    
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }    

    public static function getSubscribedEvents(): array
    {
        return [
            // the priority must be greater than the Security HTTP
            // ExceptionListener, to make sure it's called before
            // the default exception listener
            KernelEvents::EXCEPTION => ['onKernelException', 2],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof AccessDeniedException) {
            return;
        }
        $routeName = 'app_main_menu';
        $status = '302';

        $url = $this->router->generate($routeName);
        $event->setResponse(new RedirectResponse($url, $status));

        // or stop propagation (prevents the next exception listeners from being called)
        //$event->stopPropagation();
    }
}

