<?php
namespace Wizard\Factory;

use Wizard\Listener\StepCollectionListener;
use Wizard\Listener\WizardListener;
use Wizard\Wizard;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WizardFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Wizard
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $wizard \Wizard\WizardInterface */
        $wizard = new Wizard();

        $application = $serviceLocator->get('Application');

        $request = $application->getRequest();
        $wizard->setRequest($request);

        $response = $application->getResponse();
        $wizard->setResponse($response);

        $formFactory = $serviceLocator->get('Wizard\Form\FormFactory');
        $wizard->setFormFactory($formFactory);
        
        $wizardListener = new WizardListener();
        $wizard->getEventManager()->attachAggregate($wizardListener);

        $stepListener = new StepCollectionListener();
        $stepCollection = $wizard->getSteps();
        $stepCollection->getEventManager()->attachAggregate($stepListener);
        
        return $wizard;
    }
}