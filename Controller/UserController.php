<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

class UserController extends AbstractController
{
    public function findByUIDAction()
    {
        $status = 200;
        $providers = $this->get('request')->query->get('UID');
        $data = $providers;

        $content = json_encode($data);
        $headers = array('Content-Type' => 'application/json');

        // support JSONP
        $callback = $this->get('request')->query->get('callback');
        if ($callback) {
            $content = sprintf('%s(%s)', $callback, $content);
            $headers['Content-Type'] = 'application/javascript';
        }

        return $this->createResponse($content, $status, $headers);
    }

    public function oathRedirect()
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
