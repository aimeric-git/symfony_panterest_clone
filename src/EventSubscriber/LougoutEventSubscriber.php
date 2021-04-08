<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Security\Http\Event\LogoutEvent; 

class LougoutEventSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;

    public function __constructor(UrlGenerator $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator; 
    }

    public function onLogoutEvent(LogoutEvent $event)
    {
        $event->getRequest()->getSession()->getFlashBag()->add(
            'success', 
            'Logged out successfully'. ' ' . $event->getToken()->getUser()->getLastName() 
        );
        
        // $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_index')));

    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
