<?php
namespace Wizard\Service;

use Wizard\WizardInterface;
use Zend\Session\SessionManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WizardInitializer implements InitializerInterface
{
    /**
     * @param  object $instance
     * @param  ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof WizardInterface) {
            //$config = $serviceLocator->get('Config');
            //$configuration = new Configuration($config['wizard']);

            $application = $serviceLocator->get('Application');

            $request = $application->getRequest();
            $response = $application->getResponse();
            $routeMatch = $application->getMvcEvent()->getRouteMatch();

            $sessionStorage = $serviceLocator->get('session');
            $sessionManager = new SessionManager(null, $sessionStorage);

            $instance
                ->setRequest($request)
                ->setResponse($response)
                ->setRouteMatch($routeMatch)
                ->setSessionManager($sessionManager);
        }
    }
}