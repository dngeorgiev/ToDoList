<?php
	class DbHelper
	{
		private static $dsn = "mysql:dbname=todo_list;host=localhost";
		private static $dbUser = "todo_list";
		private static $dbPassword = "Pass@1234";
		private static $dbOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

		public static function GetConnection()
		{
			$conn = null;
			try
			{
				$conn = new PDO(self::$dsn, self::$dbUser, self::$dbPassword, self::$dbOptions);
			}
			catch(PDOException $e)
			{
				die("Connection problems: " . $e->GetMessage());
			}
			return $conn;
		}
	}
?>