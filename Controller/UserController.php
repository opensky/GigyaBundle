<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

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
}
