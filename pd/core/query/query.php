<?php
namespace pd\core;
/*
 * Object Query
 * 
 * This object handles all queries
 * 
 * Selects, updates, inserts, and deletes
 * 
 * Security - Never allow user input to be the query string
 * 
 */

class query extends \pd\main {
	
  private $rec;
  
  public function __construct() {
    $this->open_mysql();
  }
  
  
  
  public function is_table($table) {
    
  }
  
  
  

	/*
	 * Select function
	 * 
	 * returns false if query was not valid
	 * 
	 * parameters
	 * 
	 * select_qry - string that defines which select query to execute
	 * data - array of data values to be used in the query statement
	 * 
	 */
  
  
	public function select($data) {
	  
    if (!pd($this->get_parent(), 'tables')->validate($data, 'select')) {
	    return false;
    }
    
    $this->set_default($data, 'select', 'match');
	  
   //include should define $data[qry] and $data[table] (optional)
	  if ($this->include_file($this->get_parent(), $data['select'], 'selects', $data)) {
	    
	  }
    else if ($this->include_file($this->get_pd(), $data['select'], 'selects', $data)) {
      
    }
    else {
      $this->err('no query found');
      return;
    }
    
    if (empty($data['qry'])) {
      $this->err('query is not being set');
    }
    //echo $data['qry'];
		$res = $this->do_qry($data['qry'], $data);
    
     //if the table is defined the records will be stored in ram
    while(($record = mysql_fetch_assoc($res))) {
      if (!empty($data['table'])) {
        $this->rec[$table][$record['id']] = $record;
      }
      $sel_ary[] = $record;
    }
    
    if (empty($sel_ary)) {
      return array();
    }
    
		return $sel_ary; 	

  }
  
  public function get($data, $field = '') {
    $this->req(array('id'), $data);
    $this->set_default($data, 'table', pd($this->get_parent(), 'tables')->get_default());
    $this->req(array('table'), $data);
    $this->set_default($field, $data['field']);

    if (!isset($this->rec[$data['table']][$data['id']])) {
      $this->rec[$data['table']][$data['id']] = $this->select_row($data);
    }
    if (!empty($field)) {
      return $this->rec[$data['table']][$data['id']][$field];
    }
    else {
      return $this->rec[$data['table']][$data['id']];
    }
  }
  
  private function select_row($data) {
    $this->req(array('id'), $data);
    $this->set_default($data, 'table', pd($this->get_parent(), 'tables')->get_default());

    $rows = $this->select(array(
      'select' => 'match',
      'table' => $data['table'],
      'fields' => array('id' => $data['id'])));
    return $rows[0];
	
  }
  
  
  public function get_count() {
    $qry = 'select FOUND_ROWS();';
    
    $res = $this->do_qry($qry);

    return mysql_result($res, 0, 'FOUND_ROWS()');
  }
  
	
	/*
	 * Gets row count from last query
	 */
	
	public function insert(&$data) {
	  if (!pd($this->get_parent(), 'tables')->validate($data, 'add')) {
	    return false;
    }
    $this->set_default($data, 'insert', pd($this->get_parent(), 'tables')->get_stored($data));
    
    $this->req(array('insert'), $data);
    

		// Find all the keys (column names) from the array $data
		$cols = array_keys($data['insert']);
		
		// Find all the values from the array $data
		$vals = array_values($data['insert']);
		
		// quote the values
		for ($i = 0; $i < count($vals); $i++){
			$vals[$i] = "'".$vals[$i]."'";
		}
		
		// Compose the query
		$qry = "INSERT INTO $data[table] ";
		
		// create comma-separated string of column names, enclosed in parentheses
		$qry .= "(" . implode(", ", $cols) . ")";
		$qry .= " values ";
		
		// create comma-separated string of values, enclosed in parentheses
		$qry .= "(" . implode(", ", $vals) . ")";
		
    $this->do_qry($qry, $data);

		$data['id'] = mysql_insert_id();
    
    $this->select_row($data);
    
    return $data['id'];
  }
	
	public function update($data) {
	  if (!pd($this->get_parent(), 'tables')->validate($data, 'edit')) {
	    return false;
    }
    $this->set_default($data, 'update', pd($this->get_parent(), 'tables')->get_stored($data));
    
    $this->req(array('update'), $data);
    
	  $this->req(array('id', 'update'), $data);
    
    //check access to this table
    
    
		/*
		 * Data is in the form
		 * 
		 * column => value
		 */

		$qry = "update $data[table] set ";

		foreach ($data['update'] as $col => $val) {
			$qry .= "$col = '$val',";
      //update rec
      //$this->rec[$data['table']][$data['id']][$col] = $val;
		}

		$qry = rtrim($qry, ',');
		
		$qry .= " where id = '$data[id]'";
		
		$this->do_qry($qry, $data);
    
    $this->select_row($data);
    
    return true;
	}
	
	public function delete($data) {
	  if (!pd($this->get_parent(), 'tables')->validate($data, 'remove')) {
	    return false;
    }
    
	  $this->req(array('id'), $data);

		$qry = " delete from $data[table] where id = '$data[id]' ";
    
    $this->do_qry($qry, $data);
    
    unset($this->rec[$data['table']][$data['id']]);
    
    return true;
	}
  
  private function do_qry($qry, $data = array()) {
    if (DEBUG_MODE) {
      $res = mysql_query($qry) or $err = mysql_error();
    }
    else {
      $res = mysql_query($qry);
    }
    
    if (!empty($err)) {
      pd($this->get_parent(), 'tables')->repair($data);
    }
    
    return $res;
  }

	public function open_mysql() {
		$conn = mysql_connect(MYSQL_LOCATION, MYSQL_USER, MYSQL_PASSWORD)
	    or die(mysql_error());
	  mysql_select_db(MYSQL_DATABASE ,$conn) or die(mysql_error());
	}
  
  
  
  
}

?>