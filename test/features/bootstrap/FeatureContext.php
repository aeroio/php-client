<?php
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

//
// Require tested files here:
//
require_once 'src/Resource.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext implements ClosuredContextInterface
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param   array   $parameters     context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->helper = new TestHelper();
        $this->phpunit = new PHPUnitHelper();
    }

    public function getStepDefinitionResources()
    {
        return Autoload::execute(__DIR__ . '/../steps/', 'steps.php');
    }

    public function getHookDefinitionResources()
    {
        //return array(__DIR__ . '/../support/hooks.php');
    }
}
