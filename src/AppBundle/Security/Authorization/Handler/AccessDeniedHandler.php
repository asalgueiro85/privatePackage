<?php
namespace AppBundle\Security\Authorization\Handler;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{

    protected $router;
    protected $security;

    public function __construct(Router $router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {

        $response = new RedirectResponse($this->router->generate('app_front_default'));
//        if ($this->security->isGranted('ROLE_ADMIN'))
//        {
//            $response = new RedirectResponse($this->router->generate('app_backend'));
//        }
//        elseif ($this->security->isGranted('ROLE_USER'))
//        {
//            $response = new RedirectResponse($this->router->generate('app_backend'));
//        }



        return $response;
    }

}