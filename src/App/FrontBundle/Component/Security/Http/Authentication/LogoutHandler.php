<?php

namespace App\FrontBundle\Component\Security\Http\Authentication;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Custom Logout success handler
 */
class LogoutHandler implements LogoutSuccessHandlerInterface
{

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onLogoutSuccess(Request $request){
    }

}