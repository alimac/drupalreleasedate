<?php
namespace DrupalReleaseDate\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PagesControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'DrupalReleaseDate\Controllers\Pages::index');
        $controllers->get('about', 'DrupalReleaseDate\Controllers\Pages::about');

        $controllers->after(function(Request $request, Response $response) {
            // Allow caching for one week.
            $response->setMaxAge(604800);
            $response->setSharedMaxAge(604800);
        });

        return $controllers;
    }
}
