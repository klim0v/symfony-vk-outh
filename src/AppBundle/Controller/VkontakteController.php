<?php
/**
 * Created by PhpStorm.
 * User: sergey
 * Date: 02.10.17
 * Time: 23:46
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VkontakteController extends Controller
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/vkontakte", name="connect_vkontakte")
     */
    public function connectAction()
    {
        // will redirect to VK!
        return $this->get('oauth2.registry')
            ->getClient('vkontakte') // key used in config.yml
            ->redirect();
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config.yml
     *
     * @Route("/connect/vkontakte/check", name="connect_vkontakte_check")
     */
    public function connectCheckAction(Request $request)
    {
        return $this->redirectToRoute('homepage');

        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)
//
//        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\VKontakteClient $client */
//        $client = $this->get('oauth2.registry')
//            ->getClient('vkontakte');
//
//        try {
//            // the exact class depends on which provider you're using
//            /** @var \J4k\OAuth2\Client\Provider\Vkontakte $user */
//            $user = $client->fetchUser();
//
//            // do something with all this new power!
////            $user->getFirstName();
//            // ...
//
//        } catch (IdentityProviderException $e) {
//            // something went wrong!
//            // probably you should return the reason to the user
//            var_dump($e->getMessage());
//            die;
//        }
    }

}