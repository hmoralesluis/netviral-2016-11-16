<?php

namespace App\FrontBundle\Component\Security\Http\Authentication;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Custom authentication success handler
 */
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    private $router;

    public function __construct(RouterInterface $router) {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        
    }

}