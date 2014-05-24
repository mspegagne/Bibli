<?php

	//Works with MYSQL
	class Db
	{
		//Singleton
		protected static $instance = null;
		
		private $password;
		
		private $username;
		
		private $database;
		
		private $server;
		
		private $connection;
		
		private $connected = false;
	
		private function __construct($server, $username, $password, $database)
		{	
			$this->server = $server;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
		}
		
		//Rajouter fonction erreur
		public static function getInstance()
		{
		
			if (self::$instance == null)
				self::$instance = new Db(_MYSQL_SERVER_, _MYSQL_USERNAME_, _MYSQL_PASSWORD_, _MYSQL_DATABASE_);
				
			if (self::$instance->connected == false)
				self::$instance->connect();
			
			return self::$instance;
		}
		
		
		//Connect to database
		private function connect()
		{
			$this->connection = mysql_connect($this->server, $this->username, $this->password);
			mysql_select_db($this->database, $this->connection);
			mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
			$this->connected = true;
			return;
		}
		
		/**
		 * Filter SQL query within a blacklist
		 *
		 * @param string $table Table where insert/update data
		 * @param string $values Data to insert/update
		 * @param string $type INSERT or UPDATE
		 * @param string $where WHERE clause, only for UPDATE (optional)
		 * @param string $limit LIMIT clause (optional)
		 * @return mixed|boolean SQL query result
		 */
		public function	autoExecute($table, $values, $type, $where = false, $limit = false)
		{
			if (!sizeof($values))
				return true;

			if (strtoupper($type) == 'INSERT')
			{
				$query = 'INSERT INTO `'.$table.'` VALUES (';
				foreach ($values AS $key => $value)
					$query .= '\''.$value.'\',';
				$query = rtrim($query, ',').')';
				if ($limit)
					$query .= ' LIMIT '.(int)($limit);
				return $this->q($query);
			}
			elseif (strtoupper($type) == 'UPDATE')
			{
				$query = 'UPDATE `'.$table.'` SET ';
				foreach ($values AS $key => $value)
					$query .= '`'.$key.'` = \''.$value.'\',';
				$query = rtrim($query, ',');
				if ($where)
					$query .= ' WHERE '.$where;
				if ($limit)
					$query .= ' LIMIT '.(int)($limit);
				return $this->q($query);
			}
			
			return false;
		}
		
		
		//Execute a request and return either an associative array, or a boolean, depending on the request type
		/*
		*@param string $query query to execute
		*@return mixed|boolean|associative array SQL query result
		*/
		public function q($query)
		{
		
			$tab_res = array();
			$res = null;
		
			if (!$this->connected)
				$this->connect();
			
			$ret = mysql_query($query, $this->connection);
			
			if ($ret === false)
				return false;
				
			if (is_resource($ret))
			{
				while ($res = mysql_fetch_array($ret))
					$tab_res[sizeof($tab_res)] = $res;
					return $tab_res;
			}
			else{
			return true;
			
			}
				
		}
		
		public function disconnect()
		{
			mysql_close($this->connection);
		}
		
		//Get the first value of the first row
		public function getValue($query)
		{
			$res = $this->getRow($query);
			if (!$res)
				return false;
			
			return $res[0];
		}
		
		//Get only the first row
		public function getRow($query)
		{
			$res = $this->q($query);
			if (!$res)
				return false;
				
			return $res[0];
		}
		
		
	}
?>