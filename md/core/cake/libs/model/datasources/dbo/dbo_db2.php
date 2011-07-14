<?php
/* SVN FILE: $Id: dbo_db2.php 184 2009-02-23 03:40:04Z rajesh_04ag02 $ */
/**
 * IBM DB2 for DBO
 *
 * This file supports IBM DB2 and Cloudscape (aka Apache Derby,
 * Sun Java DB) using the native ibm_db2 extension:
 * http://pecl.php.net/package/ibm_db2
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2007, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.model.datasources.dbo
 * @since         CakePHP(tm) v 0.10.5.1790
 * @version       $Revision: 8015 $
 * @modifiedby    $LastChangedBy: mark_story $
 * @lastmodified  $Date: 2009-02-04 10:30:59 +0530 (Wed, 04 Feb 2009) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
/**
 * IBM DB2 for DBO
 *
 * This file supports IBM DB2 and Cloudscape (aka Apache Derby,
 * Sun Java DB) using the native ibm_db2 extension:
 * http://pecl.php.net/package/ibm_db2
 *
 * @package       cake
 * @subpackage    cake.cake.libs.model.datasources.dbo
 */
class DboDb2 extends DboSource {
/**
 * A short description of the type of driver.
 *
 * @var string
 */
	var $description = 'IBM DB2 DBO Driver';
/**
 * The start quote in which database column and table names should be wrapped.
 *
 * @var string
 */
	var $startQuote = '';
/**
 * The end quote in which database column and table names should be wrapped.
 *
 * @var string
 */
	var $endQuote = '';
/**
 * An array of base configuration settings to be used if settings are not
 * provided, i.e. default host, port, and connection method.
 *
 * @var array
 */
	var $_baseConfig = array(
		'persistent' 	=> true,
		'login' 		=> 'db2inst1',
		'password' 		=> '',
		'database' 		=> 'cake',
		'schema'		=> '',
		'hostname'		=> '127.0.0.1',
		'port'			=> '50001',
		'encoding'		=> 'UTF-8',
		'cataloged'		=> true,
		'autocommit'	=> true
	);
/**
 * An array that maps Cake column types to database native column types.
 * The mapped information can include a reference to a function that should
 * be used to format the data, as well as a string that defines the
 * formatting according to that function.
 *
 * @var array
 */
	var $columns = array(
		'primary_key' 	=> array('name' => 'not null generated by default as identity (start with 1, increment by 1)'),
		'string' 		=> array('name' => 'varchar', 'limit' => '255'),
		'text' 			=> array('name' => 'clob'),
		'integer' 		=> array('name' => 'integer', 'limit' => '10', 'formatter' => 'intval'),
		'float' 		=> array('name' => 'double', 'formatter' => 'floatval'),
		'datetime' 		=> array('name' => 'timestamp', 'format' => 'Y-m-d-H.i.s', 'formatter' => 'date'),
		'timestamp' 	=> array('name' => 'timestamp', 'format' => 'Y-m-d-H.i.s', 'formatter' => 'date'),
		'time' 			=> array('name' => 'time', 'format' => 'H.i.s', 'formatter' => 'date'),
		'date' 			=> array('name' => 'date', 'format' => 'Y-m-d', 'formatter' => 'date'),
		'binary' 		=> array('name' => 'blob'),
		'boolean' 		=> array('name' => 'smallint', 'limit' => '1')
	);
/**
 * A map for every result mapping tables to columns
 *
 * @var array result -> ( table -> column )
 */
	var $_resultMap = array();
/**
 * Connects to the database using options in the given configuration array.
 *
 * @return boolean True if the database could be connected, else false
 */
	function connect() {
		$config = $this->config;
		$connect = 'db2_connect';
		if ($config['persistent']) {
			$connect = 'db2_pconnect';
		}
		$this->connected = false;

		if ($config['cataloged']) {
			$this->connection = $connect($config['database'], $config['login'], $config['password']);
		} else {
			$connString = sprintf(
				"DRIVER={IBM DB2 ODBC DRIVER};DATABASE=%s;HOSTNAME=%s;PORT=%d;PROTOCOL=TCPIP;UID=%s;PWD=%s;",
				$config['database'],
				$config['hostname'],
				$config['port'],
				$config['login'],
				$config['password']
			);
			$this->connection = db2_connect($connString, '', '');
		}

		if ($this->connection) {
			$this->connected = true;
		}

		if ($config['schema'] !== '') {
			$this->_execute('SET CURRENT SCHEMA = ' . $config['schema']);
		}
		return $this->connected;
	}
/**
 * Disconnects from database.
 *
 * @return boolean True if the database could be disconnected, else false
 */
	function disconnect() {
		@db2_free_result($this->results);
		$this->connected = !@db2_close($this->connection);
		return !$this->connected;
	}
/**
 * Executes given SQL statement.  We should use prepare / execute to allow the
 * database server to reuse its access plan and increase the efficiency
 * of your database access
 *
 * @param string $sql SQL statement
 * @return resource Result resource identifier
 * @access protected
 */
	function _execute($sql) {
		// get result from db
		$result = db2_exec($this->connection, $sql);

		if (!is_bool($result)) {
			// build table/column map for this result
			$map = array();
			$numFields = db2_num_fields($result);
			$index = 0;
			$j = 0;
			$offset = 0;

			while ($j < $numFields) {
				$columnName = strtolower(db2_field_name($result, $j));
				$tmp = strpos($sql, '.' . $columnName, $offset);
				$tableName = substr($sql, $offset, ($tmp-$offset));
				$tableName = substr($tableName, strrpos($tableName, ' ') + 1);
				$map[$index++] = array($tableName, $columnName);
				$j++;
				$offset = strpos($sql, ' ', $tmp);
			}

			$this->_resultMap[$result] = $map;
		}

		return $result;
	}
/**
 * Returns an array of all the tables in the database.
 * Should call parent::listSources twice in the method:
 * once to see if the list is cached, and once to cache
 * the list if not.
 *
 * @return array Array of tablenames in the database
 */
	function listSources() {
		$cache = parent::listSources();

		if ($cache != null) {
			return $cache;
		}
		$result = db2_tables($this->connection);
		$tables = array();

		while (db2_fetch_row($result)) {
			$tables[] = strtolower(db2_result($result, 'TABLE_NAME'));
		}
		parent::listSources($tables);
		return $tables;
	}
/**
 * Returns an array of the fields in given table name.
 *
 * @param Model $model Model object to describe
 * @return array Fields in table. Keys are name and type
 */
	function &describe(&$model) {
		$cache = parent::describe($model);

		if ($cache != null) {
			return $cache;
		}
		$fields = array();
		$result = db2_columns($this->connection, '', '', strtoupper($this->fullTableName($model)));

		while (db2_fetch_row($result)) {
			$fields[strtolower(db2_result($result, 'COLUMN_NAME'))] = array(
				'type' => $this->column(strtolower(db2_result($result, 'TYPE_NAME'))),
				'null' => db2_result($result, 'NULLABLE'),
				'default' => db2_result($result, 'COLUMN_DEF'),
				'length' => db2_result($result, 'COLUMN_SIZE')
			);
		}
		$this->__cacheDescription($model->tablePrefix . $model->table, $fields);
		return $fields;
	}
/**
 * Returns a quoted name of $data for use in an SQL statement.
 *
 * @param string $data Name (table.field) to be prepared for use in an SQL statement
 * @return string Quoted for MySQL
 */
	function name($data) {
		return $data;
	}
/**
 * Returns a quoted and escaped string of $data for use in an SQL statement.
 *
 * @param string $data String to be prepared for use in an SQL statement
 * @param string $column The column into which this data will be inserted
 * @return string Quoted and escaped
 * @todo Add logic that formats/escapes data based on column type
 */
	function value($data, $column = null, $safe = false) {
		$parent = parent::value($data, $column, $safe);

		if ($parent != null) {
			return $parent;
		}

		if ($data === null) {
			return 'NULL';
		}

		if ($data === '') {
			return  "''";
		}

		switch ($column) {
			case 'boolean':
				$data = $this->boolean((bool)$data);
			break;
			case 'integer':
				$data = intval($data);
			break;
			default:
				$data = str_replace("'", "''", $data);
			break;
		}

		if ($column == 'integer' || $column == 'float') {
			return $data;
		}
		return "'" . $data . "'";
	}
/**
 * Not sure about this one, MySQL needs it but does ODBC?  Safer just to leave it
 * Translates between PHP boolean values and MySQL (faked) boolean values
 *
 * @param mixed $data Value to be translated
 * @return mixed Converted boolean value
 */
	function boolean($data) {
		if ($data === true || $data === false) {
			if ($data === true) {
				return 1;
			}
			return 0;
		} else {
			if (intval($data !== 0)) {
				return true;
			}
			return false;
		}
	}
/**
 * Begins a transaction.  Returns true if the transaction was
 * started successfully, otherwise false.
 *
 * @param unknown_type $model
 * @return boolean True on success, false on fail
 * (i.e. if the database/model does not support transactions).
 */
	function begin(&$model) {
		if (parent::begin($model)) {
			if (db2_autocommit($this->connection, DB2_AUTOCOMMIT_OFF)) {
				$this->_transactionStarted = true;
				return true;
			}
		}
		return false;
	}
/**
 * Commit a transaction
 *
 * @param unknown_type $model
 * @return boolean True on success, false on fail
 * (i.e. if the database/model does not support transactions,
 * or a transaction has not started).
 */
	function commit(&$model) {
		if (parent::commit($model)) {
			if (db2_commit($this->connection)) {
				$this->_transactionStarted = false;
				db2_autocommit($this->connection, DB2_AUTOCOMMIT_ON);
				return true;
			}
		}
		return false;
	}
/**
 * Rollback a transaction
 *
 * @param unknown_type $model
 * @return boolean True on success, false on fail
 * (i.e. if the database/model does not support transactions,
 * or a transaction has not started).
 */
	function rollback(&$model) {
		if (parent::rollback($model)) {
			$this->_transactionStarted = false;
			db2_autocommit($this->connection, DB2_AUTOCOMMIT_ON);
			return db2_rollback($this->connection);
		}
		return false;
	}
/**
 * Removes Identity (primary key) column from update data before returning to parent
 *
 * @param Model $model
 * @param array $fields
 * @param array $values
 * @return array
 */
	function update(&$model, $fields = array(), $values = array()) {
		foreach ($fields as $i => $field) {
			if ($field == $model->primaryKey) {
				unset ($fields[$i]);
				unset ($values[$i]);
				break;
			}
		}
		return parent::update($model, $fields, $values);
	}
/**
 * Returns a formatted error message from previous database operation.
 * DB2 distinguishes between statement and connnection errors so we
 * must check for both.
 *
 * @return string Error message with error number
 */
	function lastError() {
		if (db2_stmt_error()) {
			return db2_stmt_error() . ': ' . db2_stmt_errormsg();
		} elseif (db2_conn_error()) {
			return db2_conn_error() . ': ' . db2_conn_errormsg();
		}
		return null;
	}
/**
 * Returns number of affected rows in previous database operation. If no previous operation exists,
 * this returns false.
 *
 * @return integer Number of affected rows
 */
	function lastAffected() {
		if ($this->_result) {
			return db2_num_rows($this->_result);
		}
		return null;
	}
/**
 * Returns number of rows in previous resultset. If no previous resultset exists,
 * this returns false.
 *
 * @return integer Number of rows in resultset
 */
	function lastNumRows() {
		if ($this->_result) {
			return db2_num_rows($this->_result);
		}
		return null;
	}
/**
 * Returns the ID generated from the previous INSERT operation.
 *
 * @param unknown_type $source
 * @return in
 */
	function lastInsertId($source = null) {
		$data = $this->fetchRow(sprintf('SELECT SYSIBM.IDENTITY_VAL_LOCAL() AS ID FROM %s FETCH FIRST ROW ONLY', $source));

		if ($data && isset($data[0]['id'])) {
			return $data[0]['id'];
		}
		return null;
	}
/**
 * Returns a limit statement in the correct format for the particular database.
 *
 * @param integer $limit Limit of results returned
 * @param integer $offset Offset from which to start results
 * @return string SQL limit/offset statement
 */
	function limit($limit, $offset = null) {
		if ($limit) {
			$rt = '';

			// If limit is not in the passed value already, add a limit clause.
			if (!strpos(strtolower($limit), 'limit') || strpos(strtolower($limit), 'limit') === 0) {
				$rt = sprintf('FETCH FIRST %d ROWS ONLY', $limit);
			}

			// TODO: Implement paging with the offset.  This could get hairy.
			/*
 			WITH WHOLE AS
			(SELECT FIRSTNME, MIDINIT, LASTNAME, SALARY,
			ROW_NUMBER() OVER (ORDER BY SALARY DESC) AS RN
			FROM EMPLOYEE)
			SELECT FIRSTNME, MIDINIT, LASTNAME, SALARY, RN
			FROM WHOLE
			WHERE RN BETWEEN 10 AND 15
			*/

			/*
			if ($offset) {
				$rt .= ' ' . $offset . ',';
			}

			$rt .= ' ' . $limit;
			*/

			return $rt;
		}
		return null;
	}
/**
 * Converts database-layer column types to basic types
 *
 * @param string $real Real database-layer column type (i.e. "varchar(255)")
 * @return string Abstract column type (i.e. "string")
 */
	function column($real) {
		if (is_array($real)) {
			$col = $real['name'];

			if (isset($real['limit'])) {
				$col .= '(' . $real['limit'] . ')';
			}
			return $col;
		}
		$col                = str_replace(')', '', $real);
		$limit              = null;
		if (strpos($col, '(') !== false) {
			list($col, $limit) = explode('(', $col);
		}

		if (in_array($col, array('date', 'time', 'datetime', 'timestamp'))) {
			return $col;
		}

		if ($col == 'smallint') {
			return 'boolean';
		}

		if (strpos($col, 'char') !== false) {
			return 'string';
		}

		if (strpos($col, 'clob') !== false) {
			return 'text';
		}

		if (strpos($col, 'blob') !== false || $col == 'image') {
			return 'binary';
		}

		if (in_array($col, array('double', 'real', 'decimal'))) {
			return 'float';
		}
		return 'text';
	}
/**
 * Maps a result set to an array so that returned fields are
 * grouped by model.  Any calculated fields, or fields that
 * do not correspond to a particular model belong under array
 * key 0.
 *
 * 1. Gets the column headers
 * {{{
 * Post.id
 * Post.title
 *
 *  [0] => Array
 *       (
 *           [0] => Post
 *           [1] => id
 *       )
 *
 *  [1] => Array
 *      (
 *          [0] => Post
 *          [1] => title
 *      )
 * }}}
 * @param unknown_type $results
 */
	function resultSet(&$results, $sql = null) {
		$this->results =& $results;
		$this->map = $this->_resultMap[$this->results];
	}
/**
 * Fetches the next row from the current result set
 * Maps the records in the $result property to the map
 * created in resultSet().
 *
 * 2. Gets the actual values.
 *
 * @return unknown
 */
	function fetchResult() {
		if ($row = db2_fetch_array($this->results)) {
			$resultRow = array();
			$i = 0;

			foreach ($row as $index => $field) {
				$table = $this->map[$index][0];
				$column = strtolower($this->map[$index][1]);
				$resultRow[$table][$column] = $row[$index];
				$i++;
			}
			return $resultRow;
		}
		return false;
	}
}
?>