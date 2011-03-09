<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

class RegisterController extends AbstractController
{
    /**
     * Are you a new user to the local app
     * Or an existing local app user with an account unlinked to Gigya?
     */
    public function chooseAction()
    {
        $parameters = array();
        $parameters['provider'] = 'facebook';

        return $this->render('GigyaBundle:Register:choose.html.twig', $parameters);
    }

    /**
     * I'm a new user to the local app
     */
    public function createAction()
    {
        $parameters = array();
        return $this->render('GigyaBundle:Register:create.html.twig', $parameters);
    }

    /**
     * I'm an existing local app user with an account unlinked to Gigya
     */
    public function linkAction()
    {
        $parameters = array();
        return $this->render('GigyaBundle:Register:link.html.twig', $parameters);
    }
}

