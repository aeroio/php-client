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

require_once 'app/AeroClient.php';
/**
 * Features context.
 */
class FeatureContext extends BehatContext
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

	/////////////////////////
	//                     //
	//  GET all projects   //
	//                     //
	/////////////////////////

	/**
     * @Given /^I have created the following projects in Aero\.cx:$/
     */
    public function iHaveCreatedTheFollowingProjectsInAeroCx(TableNode $projectsTable)
    {
		$projects = $this->helper->columnToArray($projectsTable);

		$this->data_parser = $this->phpunit->getMock('DataParser', array('execute'));

		$this->data_parser->expects($this->phpunit->once())
			->method('execute')
			->will($this->phpunit->returnValue($projects));
    }

    /**
     * @When /^I initialize the AeroClient and want to get all of my projects$/
     */
    public function iInitializeTheAeroclientAndWantToGetAllOfMyProjects()
    {
		$aero = new AeroClient();
		$aero->setDataParser($this->data_parser);
		$this->projects = $aero->getProjects();
    }

    /**
     * @Then /^I should receive the following projects:$/
     */
    public function iShouldReceiveTheFollowingProjects(TableNode $projectsTable)
    {
		$projects = $this->helper->columnToArray($projectsTable);

		assertEquals($projects, $this->projects);
    }

	/////////////////////////
	//                     //
	// GET project with ID //
	//                     //
	/////////////////////////

	/**
     * @Given /^I have created project "([^"]*)" with id "([^"]*)" in Aero\.cx$/
     */
    public function iHaveCreatedProjectWithIdInAeroCx($project_name, $project_id)
    {
		$project = array('id' => $project_id, 'name' => $project_name);
		$url = '/v1/project/' . $project_id;

		$this->data_parser = $this->phpunit->getMock('DataParser', array('execute'));

		$this->data_parser->expects($this->phpunit->once())
			->method('execute')
			->will($this->phpunit->returnValue($project))
			->with($url);
    }

    /**
     * @When /^I initialize the AeroCLient and want to get this project$/
     */
    public function iInitializeTheAeroclientAndWantToGetThisProject()
    {
        $aero = new AeroClient();
		$aero->setDataParser($this->data_parser);
		$this->project = $aero->getProject(1);
    }

    /**
     * @Then /^I should receive project "([^"]*)" with id "([^"]*)"$/
     */
    public function iShouldReceiveProjectWithId($project_name, $project_id)
    {
		$project = array('id' => $project_id, 'name' => $project_name);

		assertEquals($project, $this->project);
    }
}
