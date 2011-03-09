<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use OpenSky\Bundle\GigyaBundle\Document\User;
use OpenSky\Bundle\GigyaBundle\Form\RegisterByEmailForm;
use Symfony\Component\DependencyInjection\ContainerAware;

class ExampleController extends AbstractController
{
    /**
     * I'm a new user to the local app
     */
    public function registerByEmailAction()
    {
        $parameters = array();
        $parameters['provider'] = 'twitter';

        $user = new User();
        $form = new RegisterByEmailForm('Register',  array('data_class' => $user, 'validator' => $this->get('validator')));

        if (is_array($requestData = $this->container->get('request')->request->get($form->getName()))) {
            $form->bind($requestData);
            if ($form->isValid()) {
                $this->get('doctrine.odm.mongodb.document_manager')->getRepository('OpenSky\Bundle\GigyaBundle\Document\User');
            }
        }

        $parameters['form'] = $form;

        return $this->render('GigyaBundle:Example:register.html.twig', $parameters);
    }
}
