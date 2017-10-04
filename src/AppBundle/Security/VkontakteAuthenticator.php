<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 03.10.17
 * Time: 0:28
 */

class VkontakteAuthenticator extends SocialAuthenticator
{

    private $clientRegistry;
    private $em;
    private $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManager $em, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->em = $em;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        if ($request->getPathInfo() != '/connect/vkontakte/check') {
            // don't auth
            return;
        }

        return $this->fetchAccessToken($this->getVkontakteClient());
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /** @var \League\OAuth2\Client\Token\AccessToken $credentials */
        /** @var \J4k\OAuth2\Client\Provider\User $vkontakteUser */
        $vkontakteUser = $this->getVkontakteClient()
            ->fetchUserFromToken($credentials);

        $email = $credentials->getValues()['email'];

        // 1) have they logged in with Facebook before? Easy!
        $existingUser = $this->em->getRepository('AppBundle:User')
            ->findOneBy(['vkontakteId' => $vkontakteUser->getId()]);
        if ($existingUser) {
            return $existingUser;
        }

        // 2) do we have a matching user by email?
        /** @var User $user */
        $user = $this->em->getRepository('AppBundle:User')
            ->findOneBy(['email' => $email]);

        // 3) Maybe you just want to "register" them by creating
        // a User object
        if (!$user) {
            $user = new User();
        }
        $user->setUsername($vkontakteUser->getScreenName());
        $user->setFirstName($vkontakteUser->getFirstName());
        $user->setLastName($vkontakteUser->getLastName());
        $user->setEmail($email);
//        }
        $user->setVkontakteId($vkontakteUser->getId());
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @return \KnpU\OAuth2ClientBundle\Client\Provider\VKontakteClient
     */
    private function getVkontakteClient()
    {
        return $this->clientRegistry
            // "vkontakte" is the key used in config.yml
            ->getClient('vkontakte');
    }

    // ...

    /**
     * Returns a response that directs the user to authenticate.
     *
     * This is called when an anonymous request accesses a resource that
     * requires authentication. The job of this method is to return some
     * response that "helps" the user start into the authentication process.
     *
     * Examples:
     *  A) For a form login, you might redirect to the login page
     *      return new RedirectResponse('/login');
     *  B) For an API token authentication system, you return a 401 response
     *      return new Response('Auth header required', 401);
     *
     * @param Request $request The request that resulted in an AuthenticationException
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $authException The exception that started the authentication process
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function start(
        Request $request,
        \Symfony\Component\Security\Core\Exception\AuthenticationException $authException = null
    ) {
        // TODO: Implement start() method.
        /*
        $data = array(
            // you might translate this message
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
        */
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the login page or a 403 response.
     *
     * If you return null, the request will continue, but the user will
     * not be authenticated. This is probably not what you want to do.
     *
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function onAuthenticationFailure(
        Request $request,
        \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
    ) {
        // TODO: Implement onAuthenticationFailure() method.

        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function onAuthenticationSuccess(
        Request $request,
        \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token,
        $providerKey
    ) {
        // TODO: Implement onAuthenticationSuccess() method.

        // on success, let the request continue
        $referer = $request->headers->get('referer');
        if (!empty($referer)) {
            return new RedirectResponse($referer);
        }
        return null;
    }
}