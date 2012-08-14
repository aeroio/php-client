<?php
	$steps->Given('/^I have account in Aero\.cx with token "([^"]*)" and sid "([^"]*)"$/',
		function($world, $auth_token, $sid) {
			$world->parameters = array(
				'auth_token' => $auth_token,
				'sid' => $sid,
				'curl' => false
			);
		}
	);

	$steps->When('/^I initialize AeroClient with this information$/',
		function($world) {
			$aero = new AeroClient($world->parameters);

			$data_parser = $world->phpunit->getMock('DataParser', array('executeHttp'));
			$aero->setDataParser($data_parser);
			$aero->getProjects();

			$world->request = $aero->getRequest();
		}
	);

	$steps->Then('/^it should be set into the header of the request$/',
		function($world) {
			$auth_token = $world->parameters['auth_token'];
			$sid = $world->parameters['sid'];

			$expected = "Authorization: Basic " . base64_encode("$auth_token:$sid");
			$result = $world->request->getHeader();

			$world->phpunit->assertEquals($expected, $result);
		}
	);
?>
