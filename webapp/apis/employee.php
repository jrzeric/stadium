<?php
	//allow outside access
	header('Access-Control-Allow-Origin: *');
	//allow methods
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

	//allow headers
	//header('Access-Control-Allow-Headers: username, token');
	//use files



	require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/employee.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/models/role.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/stadium/webapp/security/security.php');

	//validate token
	/*
	$headers = getallheaders(); //get headers
	if (isset($headers['username']) && isset($headers['token'])) {
		if ($headers['token'] != Security::generateToken($headers['username'])) {
			echo json_encode(array(
				'status' => 2,
				'errorMessage' => 'Invalid security headers'
			));
			die(); //en process
		}
	}
	else {
		echo json_encode(array(
			'status' => 1,
			'errorMessage' => 'Missing security headers'
		));
		die(); //en process
	}*/
	//GET
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		//one object
		if (isset($_GET['id'])) {
			try {
				//create object
				$e = new Employee($_GET['id']);
				//display
				echo json_encode(array(
					'status' => 0,
					'employee' => json_decode($e->toJson())
				));
			}
			catch(RecordNotFoundException $ex) {
				echo json_encode(array(
					'status' => 1,
					'errorMessage' => $ex->get_message()
				));
			}
		}
		else {
			echo Employee::getAllJson();
		}

	}
	//POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		//check parameters
		if (isset($_POST['nombre']) &&
			isset($_POST['apPaterno']) &&
			isset($_POST['apMaterno']) &&
			isset($_POST['nameUser']) &&
			isset($_POST['password']) &&
			isset($_POST['role'])) {
				//validation
				$error = false;
				//building type
				try
				{
					$role = new Role($_POST['role']);
				}
				catch(RecordNotFoundException $ex)
				{
					$error = true; //found error
					echo json_encode(array(
						'status' => 2,
						'errorMessage' => 'Invalid role'
					));
				}
				if (!$error)
				{
					//create building object
					$e = new Employee();
					//assign values
					$e->setNombre($_POST['nombre']);
					$e->setApPaterno($_POST['apPaterno']);
					$e->setApMaterno($_POST['apMaterno']);
					$e->setApMaterno($_POST['apMaterno']);
					$e->getUser()->setName($_POST['nameUser']);
					$e->getUser()->setPassword($_POST['password']);
					$e->getUser()->setRole($role);
					//add
					if ($e->add())
						echo json_encode(array(
							'status' => 0,
							'errorMessage' => 'Building added successfully'
						));
					else
						echo json_encode(array(
							'status' => 3,
							'errorMessage' => 'Could not add building'
						));

				}
			}
		else
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing Parameters'
			));


	}
	//PUT
	if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
		//read parameters
		parse_str(file_get_contents('php://input'), $putData);
		//check parameters
		if (isset($putData['data'])) {
			//encode data parameter
			$jsonData = json_decode($putData['data'], true);
			//check parameters
			if (isset($jsonData['id']) &&
				isset($jsonData['name']) &&
				isset($jsonData['latitude']) &&
				isset($jsonData['longitude']) &&
				isset($jsonData['typeid']) ) {
				//validate building type
				$error = false;
				try {
					$bt = new BuildingType($jsonData['typeid']);
				}
				catch(RecordNotFoundException $ex) {
					$error = true;
					echo json_encode(array(
						'status' => 3,
						'errorMessage' => 'Invalid building type'
					));
				}
				//building
				if (!$error) {
					try {
						$b = new Building($jsonData['id']);
						//set new values
						$b->setName($jsonData['name']);
						$b->setLocation(new Location($jsonData['latitude'], $jsonData['longitude']));
						$b->setType($bt);
						//edit
						if ($b->edit())
							echo json_encode(array(
								'status' => 0,
								'errorMessage' => 'Building edited successfully'
							));
						else
							echo json_encode(array(
								'status' => 5,
								'errorMessage' => 'Could not edit building'
							));
					}
					catch(RecordNotFoundException $ex) {
						echo json_encode(array(
							'status' => 4,
							'errorMessage' => 'Invalid building id'
						));
					}
				}
			}
			else
				echo json_encode(array(
					'status' => 2,
					'errorMessage' => 'Invalid JSON data'
				));
		}
		else
			echo json_encode(array(
				'status' => 1,
				'errorMessage' => 'Missing data parameter'
			));
	}
	//DELETE
	if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
		echo 'DELETE';
	}
?>
