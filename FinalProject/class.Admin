<?php
	class Admin{
		public $adminID;
		public $database;
		public $name;
		function __construct($adminID, $database){
			$sql = file_get_contents('sql/getAdmin.sql');
			$params = array(
				'adminid' => $_SESSION["adminID"]
			);
			$statement = $database->prepare($sql);
			$statement->execute($params);
			$admins = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			$this->adminID = $adminID;
			$this->database = $database;
			$admin = $admins[0];
			$this->name = $admin['name']; 
		}
	}
	
?>