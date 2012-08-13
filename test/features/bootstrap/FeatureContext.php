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

	/////////////////////////
	//                     //
	//     POST project    //
	//                     //
	/////////////////////////

	/**
     * @Given /^I have built a project "([^"]*)" with description "([^"]*)"$/
     */
    public function iHaveBuiltAProjectWithDescription($project_name, $project_description)
    {
        $this->project = array('name' => $project_name, 'description' => $project_description);

		$url = '/v1/projects';

		$this->data_parser = $this->phpunit->getMock('DataParser', array('execute'));

		$this->data_parser->expects($this->phpunit->once())
			->method('execute')
			->will($this->phpunit->returnValue($this->project))
			->with($url);
    }

    /**
     * @When /^I initialize the AeroClient and want to save it there$/
     */
    public function iInitializeTheAeroclientAndWantToSaveItThere()
    {
		$aero = new AeroClient();
		$aero->setDataParser($this->data_parser);
		$this->saved_project = $aero->createProject($this->project);
    }

	/**
     * @Then /^I should receive project "([^"]*)" with description "([^"]*)"$/
     */
    public function iShouldReceiveProjectWithDescription($project_name, $project_description)
    {
        $this->project = array('name' => $project_name, 'description' => $project_description);

		assertEquals($this->project, $this->saved_project);
    }

	/////////////////////////
	//                     //
	//   Update project    //
	//                     //
	/////////////////////////

	/**
     * @Given /^I have created project with id "([^"]*)"$/
     */
    public function iHaveCreateProjectWithIdAndDescription($project_id)
    {
		$this->project_id = $project_id;
		$this->url = '/v1/project/' . $project_id;
    }

    /**
     * @When /^I initialize the AeroClient and want to update it to "([^"]*)" with description "([^"]*)"$/
     */
    public function iInitializeTheAeroclientAndWantToUpdateItToWithDescription($project_name, $project_description)
    {
		$this->project = array('name' => $project_name, 'description' => $project_description);

		$data_parser = $this->phpunit->getMock('DataParser', array('execute'));

		$data_parser->expects($this->phpunit->once())
			->method('execute')
			->will($this->phpunit->returnValue($this->project))
			->with($this->url);

		$aero = new AeroClient();
		$aero->setDataParser($data_parser);
		$this->project = $aero->updateProject($this->project_id, $this->project);
    }

    /**
     * @Then /^I should receive the updated project "([^"]*)" with description "([^"]*)"$/
     */
    public function iShouldReceiveProjectWithIdAndDescription($project_name, $project_description)
    {
        $project = array('name' => $project_name, 'description' => $project_description);

		assertEquals($project, $this->project);
    }

	/**
     * @Given /^I have account in Aero\.cx with token "([^"]*)" and sid "([^"]*)"$/
     */
    public function iHaveAccountInAeroCxWithTokenAndSid($auth_token, $sid)
    {
		$this->auth_token = $auth_token;
		$this->sid = $sid;
    }

    /**
     * @When /^I initialize AeroClient with this information$/
     */
    public function iInitializeAeroclientWithThisInformation()
    {
		$aero = new AeroClient($this->auth_token, $this->sid);

		$data_parser = $this->phpunit->getMock('DataParser', array('execute'));
		$aero->setDataParser($data_parser);
		$aero->getProjects();

		$this->request = $aero->getRequest();
    }

    /**
     * @Then /^it should be set into the header of the request$/
     */
    public function itShouldBeSetIntoTheHeaderOfTheRequest()
    {
		$expected = "Authorization: Basic " . base64_encode("$this->auth_token:$this->sid");
		$result = $this->request->getHeader();

		$this->phpunit->assertEquals($expected, $result);
    }
}
