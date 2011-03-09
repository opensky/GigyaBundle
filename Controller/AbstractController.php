<?php

namespace OpenSky\Bundle\GigyaBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;

abstract class AbstractController extends ContainerAware
{
    /**
     * Creates a Response instance.
     *
     * @param string  $content The Response body
     * @param integer $status  The status code
     * @param array   $headers An array of HTTP headers
     *
     * @return Response A Response instance
     */
    public function createResponse($content = '', $status = 200, array $headers = array())
    {
        $response = $this->container->get('response');
        $response->setContent($content);
        $response->setStatusCode($status);
        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        return $response;
    }

    /**
     * Gets a service by id.
     *
     * @param  string $id The service id
     *
     * @return object  The service
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * Renders a view
     *
     * @param string   $view The view name
     * @param array    $parameters An array of parameters to pass to the view
     * @param Response $response A response instance
     *
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
}
