<?php
	require_once 'connect.php';

	class Db
	{
		protected $_con;

		public function __construct()
		{
			$this->_con = new mysqli(host,username,password,db) or die ('not connect');
		}

		public function select($sql='')
		{
			$query = $this->_con->query('SET NAMES UTF8');
			$query = $this->_con->query($sql);

			if ($query) 
			{
				$items = [];
				while ($row = $query->fetch_assoc()) 
				{
						$items[] = $row;
				}
				$total_rows = $query->num_rows;
				return ['items'=>$items,'num_rows'=>$total_rows];
				
			} 
		}

		public function query($sql='')
		{

			$query = $this->_con->query('SET NAMES UTF8');
			$query = $this->_con->query($sql);

			return $query;
		}

		public function insertId()
		{
			$id = $this->_con->insert_id;

			return $id;
		}



	}

?>