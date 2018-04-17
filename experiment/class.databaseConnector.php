<?php
	class databaseConnectionError Extends Exception{
		public function msg() {echo "Unable to Conncect<br/>";}
	}
	class databaseConnector{
		public function OpenCon($dbhost,$dbuser,$dbpass,$db)
		{
		try
			{$conn = new mysqli($dbhost, $dbuser, $dbpass,$db);
			if($conn->error) 
				{throw new databaseConnectionError;}
			}
		catch(databaseConnectionError $e)
			{
			$e->msg(); return 0;
			}
		return $conn;
		}
	}

?>
