<?php

namespace AppBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseOAuthUserProvider;
use Symfony\Component\DependencyInjection\ContainerInterface; //OAuthUserProvider FOSUBUserProvider

class SMUserProvider extends BaseOAuthUserProvider{

    private $serviceContainer = null;
    private $publicUserFileDir;

    public function __construct(UserManagerInterface $userManager, array $properties,
        ContainerInterface $serviceContainer, $publicUserFileDir)
    {
        parent::__construct($userManager, $properties);
        $this->serviceContainer = $serviceContainer;
        $this->publicUserFileDir = $publicUserFileDir;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        try {
            return parent::loadUserByOAuthUserResponse($response);
        } catch(AccountNotLinkedException $exception) {
            $uniqueUsername = $response->getUsername();
            $name = $response->getNickname();
            $email = $response->getEmail();
            $service = $response->getResourceOwner()->getName();
            if('google' == $service) {
                $firstName = $response->getResponse()['given_name'];
                $lastName = $response->getResponse()['family_name'];
            } else {
                $firstName = $response->getResponse()['first_name'];
                $lastName = $response->getResponse()['last_name'];
            }
            $user = $this->userManager->findUserByEmail($email);
            if(null === $user) {
                $user = $this->userManager->createUser();
                $user->setUsername($email);
                $user->setEmail($email);
                $user->setName($name);
                $user->setPlainPassword($uniqueUsername);
                $user->addRole('ROLE_CLIENT');
                $user->setEnabled(true);

//                $this->serviceContainer->get('cbook.contact_crm')->create($firstName, $lastName, $email);
            }
            // update user data
            if(null === $user->getName()) {
                $user->setName($name);
            }
            if(null === $user->getFirstName() || null === $user->getLastName()) {
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
            }

            $setter = 'set'.ucfirst($service).'ID';
            $user->$setter($uniqueUsername);

            $this->userManager->updateUser($user);

            return $user;
        }
    }

}