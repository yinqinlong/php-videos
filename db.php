<?php
class Db{
	protected $vmsConfig = array(
			'host' => 'localhost',
			'user' => 'root',
			'password' => '123',
			'port' => '3306',
			'db' => '',
		);

	protected $defaultConfig = array(
			'host' => '10.210.208.52',
			'user' => 'root',
			'password' => '123456',
			'port' => 3306,
			'db' => 'video_robber',
		);

	public $conn;
	public $table;
	public function __construct($flag = 'default') {
		if (!is_resource($this->conn)) {
			$this->conn = $this->connectDb($flag);
		} 	
	}

	protected function connectDb($flag) {
		$config = $flag . 'Config';
		$config = $this->$config;
		$conn = mysql_connect($config['host'], $config['user'], $config['password'], $config['port']);
		mysql_select_db($config['db'], $conn);
		return $conn;
	}

	public function table($table) {
		$this->table = $table;
		return $this;
	}

	public function insert(array $fileds) {
		$str = '';
		$data = array();
		foreach ($fileds as $key=>$value) {
			$data[] = '`' . $key . '`' . "=" . "'$value'"; 
		}
		$str = implode(',', $data);
		$sql = "insert into " . $this->table . ' set ' . $str;
		mysql_query($sql, $this->conn);		
		return mysql_insert_id();
	}

	public function getList($condition, $offset = 0, $limit = 10) {
		$str = '';
		if ($condition) {
			foreach ($condition as $key=>$val) {
				$data[] = '`' . $key . '`' . "=" . "'$val'"; 
			}
			$str = implode(' and ', $data);
		}
		$sql = "select * from " . $this->table ;
		if($str)
		  $sql .= ' where ' . $str;
		//$sql .= " order by status desc,createtime desc";
		$sql .= " order by createtime desc";
		$sql .= " limit $offset," . $limit;
		$result = mysql_query($sql, $this->conn);		
		$data = array();
		while($row = mysql_fetch_assoc($result)) {
			$data[] = $row;	
		}
		return $data;
	}

	public function count(array $condition) {
		$sql = 'select count(*) as total from ' . $this->table;
		$str = '';
		if ($condition) {
			foreach ($condition as $key=>$val) {
				$data[] = '`' . $key . '`' . "=" . "'$val'"; 
			}
			$str = implode(' and ', $data);
			$sql .= ' where 1 = 1 ' . $str; 
		}
		$result = mysql_query($sql, $this->conn);		
		$data = array();
		$row = mysql_fetch_assoc($result);
		return $row['total'];
	}

	public function get(array $condition) {
		foreach ($condition as $key=>$val) {
			$data[] = '`' . $key . '`' . "=" . "'$val'"; 
		}
		$str = implode(' and ', $data);
		$sql = 'select * from ' . $this->table . ' where ' . $str;	
		$result = mysql_query($sql, $this->conn);		
		return mysql_fetch_assoc($result);
	}

	public function update($id, $condition = array()) {
		foreach ($condition as $key=>$val) {
			$data[] = '`' . $key . '`' . "=" . "'$val'"; 
		}
		$str = implode(' , ', $data);
		$sql = "update " . $this->table . ' set ' . $str . ' where id = ' . $id . ' limit 1';	
		mysql_query($sql, $this->conn);
		return mysql_affected_rows();
	}

	public function __destruct() {
		unset($this->conn);
	}
}
