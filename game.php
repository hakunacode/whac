<?php
	require_once ('mysql.php');

	error_reporting(E_ALL);
	
	$db = new mysql();
	
	$db->hostname = "localhost";
	$db->username = "root";
	$db->password = "";
	$db->database = "html5";
	
	$db->connect();
	$db->selectDb('html5');
	
//	print_r($_GET);
	$action = $_GET['a'];
//	echo "-------------".$action;
	
	switch($action) {
		case 's': // save score
			$name = $_GET['n'];
			$score = $_GET['s'];
			saveScore($db, $name, $score);
			break;
		case 'l': // get top 10 score
			getTopList($db);
			break;
	}
	
	
	
	function saveScore($db, $name, $score) {
		$name = strtoupper($name);
		$query = $db->insert('whac', array('name', 'score'), array("'$name'", $score));
		$db->simpleQuery($query);
		getTopList($db);
	}
	
	function getTopList($db) {
		$query = "SELECT * FROM whac ORDER BY score DESC LIMIT 0, 10";
		$db->simpleQuery($query);
		$scoreArray = $db->result_array();
		$strValues = "[";
		$sep = "";
		foreach($scoreArray as $score) {
			$strValues .= "$sep{name: '$score->name', score: '$score->score'}";
			$sep = ",";
		}
		
		$strValues .= "]";
		echo $strValues;
	}
		
	