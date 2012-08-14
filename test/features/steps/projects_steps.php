<?php
	$steps->Given('/^I do not have cURL on my server$/', 
		function($world) {
			$world->parameters = array(
				'auth_token' => 'AUTH_TOKEN',
				'sid' => 'SID',
				'curl' => false
			);
		}
	);

	$steps->Given('/^I have cURL on my server$/', 
		function($world) {
			$world->parameters = array(
				'auth_token' => 'AUTH_TOKEN',
				'sid' => 'SID',
				'curl' => true
			);
		}
	);

	//// GET ALL PROJECTS ////

	$steps->Given('/^I have created the following projects in Aero\.cx:$/',
		function($world, $projectsTable) {
			$projects = $world->helper->columnToArray($projectsTable);

			$world->data_parser = $world->phpunit->getMock('DataParser', array('execute'));

			$world->data_parser->expects($world->phpunit->once())
				->method('execute')
				->will($world->phpunit->returnValue($projects));
		}
	);

	$steps->When('/^I initialize the AeroClient and want to get all of my projects$/',
		function($world) {
			$aero = new AeroClient($world->parameters);
			$aero->setDataParser($world->data_parser);
			$world->projects = $aero->getProjects();
		}
	);

	$steps->Then('/^I should receive the following projects:$/',
		function($world, $projectsTable) {
			$projects = $world->helper->columnToArray($projectsTable);

			assertEquals($projects, $world->projects);
		}
	);

	//// GET PROJECT WITH ID ////

	$steps->Given('/^I have created project "([^"]*)" with id "([^"]*)" in Aero\.cx$/',
		function($world, $project_name, $project_id) {
			$project = array('id' => $project_id, 'name' => $project_name);

			$world->data_parser = $world->phpunit->getMock('DataParser', array('execute'));

			$world->data_parser->expects($world->phpunit->once())
				->method('execute')
				->will($world->phpunit->returnValue($project));

		}
	);

	$steps->When('/^I initialize the AeroCLient and want to get this project$/',
		function($world) {
			$aero = new AeroClient($world->parameters);
			$aero->setDataParser($world->data_parser);
			$world->project = $aero->getProject(1);
		}
	);

	$steps->Then('/^I should receive project "([^"]*)" with id "([^"]*)"$/',
		function($world, $project_name, $project_id) {
			$project = array('id' => $project_id, 'name' => $project_name);

			assertEquals($project, $world->project);
		}
	);

	//// CREATE PROJECT ////

	$steps->Given('/^I have built a project "([^"]*)" with description "([^"]*)"$/',
		function($world, $project_name, $project_description) {
			$world->project = array('name' => $project_name, 'description' => $project_description);

			$world->data_parser = $world->phpunit->getMock('DataParser', array('execute'));

			$world->data_parser->expects($world->phpunit->once())
				->method('execute')
				->will($world->phpunit->returnValue($world->project));

		}
	);

    $steps->When('/^I initialize the AeroClient and want to save it there$/',
		function($world) {
			$aero = new AeroClient($world->parameters);
			$aero->setDataParser($world->data_parser);
			$world->saved_project = $aero->createProject($world->project);
		}
	);

	$steps->Then('/^I should receive project "([^"]*)" with description "([^"]*)"$/',
		function($world, $project_name, $project_description) {
			$world->project = array('name' => $project_name, 'description' => $project_description);

			assertEquals($world->project, $world->saved_project);
		}
	);

	//// UPDATE PROJECT ////

	$steps->Given('/^I have created project with id "([^"]*)"$/',
		function($world, $project_id) {
			$world->project_id = $project_id;
		}
	);

	$steps->When('/^I initialize the AeroClient and want to update it to "([^"]*)" with description "([^"]*)"$/',
		function($world, $project_name, $project_description) {
			$world->project = array('name' => $project_name, 'description' => $project_description);

			$data_parser = $world->phpunit->getMock('DataParser', array('execute'));

			$data_parser->expects($world->phpunit->once())
				->method('execute')
				->will($world->phpunit->returnValue($world->project));

			$aero = new AeroClient($world->parameters);
			$aero->setDataParser($data_parser);
			$world->project = $aero->updateProject($world->project_id, $world->project);
		}
	);

	$steps->Then('/^I should receive the updated project "([^"]*)" with description "([^"]*)"$/',
		function($world, $project_name, $project_description) {
			$project = array('name' => $project_name, 'description' => $project_description);

			assertEquals($project, $world->project);
		}
	);
?>
