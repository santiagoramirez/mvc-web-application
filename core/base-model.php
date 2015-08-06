<?php

/**
 * This is the Model abstract class. It acts as an abstract database class for
 * all children models.
 *
 * @author Santiago Ramirez
 * @link http://santiagoramirez.net
 * @link https://github.com/santiagoramirez
 */

class Model
{
	/**
	 * Configure the database.
	 * @var array $_conifg
	 */
	protected $_config = array(
		'dbname'      => DB_NAME,
		'dbhostname'  => DB_HOSTNAME,
		'dbusername'  => DB_USERNAME,
		'dbpassword'  => DB_PASSWORD,
        'tableprefix' => TABLE_PREFIX,
	);

	/**
	 * An instance of the PDO class.
	 * @var PDO $_db
	 */
	protected $_db;

	/**
	 * The last inserted row's ID.
	 * @var integer $_insert_id
	 */
	protected $_insert_id;

	/**
	 * The WHERE clause.
	 * @var string $_condition
	 * @see _setCondition()
	 */
	protected $_condition;

	/**
	 * The ORDER / ORDER BY clause.
	 * @var string $_ordering
	 * @see setOrdering()
	 */
	protected $_ordering;

	/**
	 * The LIMIT clause
	 * @var string $_pagination
	 * @see setPagination()
	 */
	protected $_pagination;

    /**
     * The rows that data will be added to.
     * @var array $_params_keys
     */
	protected $_param_keys = array();

    /**
     * The values to be inserted into the rows of $_param_keys.
     * @var array $_param_values
     */
	protected $_param_values = array();

    /**
     * The query to be performed.
     * @var string $_query
     */
	protected $_query;

    /**
     * Contains the result of a SELECT query.
     * @var array|false $_result
     */
	protected $_result;

    /**
     * The columns to return in a SELECT statement.
     * @var array $_columns
     */
	protected $_columns;

    /**
     * The currently selected table.
     * @var string $_table
     */
	protected $_table;

    /**
     * Establish a connection to the databse.
     */
    final protected function _connect() {
        $dsn = 'mysql:dbname='.$this->_config['dbname'].';host='.$this->_config['dbhostname'];
        $username = $this->_config['dbusername'];
        $password = $this->_config['dbpassword'];

        try {
            if (!isset($this->db)) {
                $this->db = new PDO($dsn, $username, $password);
        	}
        } catch (PDOException $e) {
            echo $e->message;
        }
    }

	/**
	 * Executes a prepared SQL statement.
	 */
	final protected function _execute() {
		$this->_connect();
		if ($stmt = $this->db->prepare($this->getQuery())) {
			$stmt->execute($this->_getParamValues());
			$this->_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}

    /**
     * @return array $_columns An array of columns to be returned
     * in an SQL SELECT query.
     */
    final protected function _getColumns() {
        if (isset($this->_columns)) {
            return $this->_columns;
        } else {
            return array('*');
        }
    }

    /**
     * @return string $_condition The WHERE clause of an SQL query.
     */
	final protected function _getCondition() {
		if (isset($this->_condition)) {
			return $this->_condition;
		} else {
			return ' ';
		}
	}

    /**
     * @return string $_ordering A fragment of SQL code which determines
     * the ordering/sorting of a query.
     */
	final protected function _getOrdering() {
        if (isset($this->_ordering)) {
            return $this->_ordering;
        } else {
            return ' ';
        }
	}

    /**
     * @return string $_pagination A fragment of SQL code which determines
     * the pagination of a SELECT query.
     */
	final protected function _getPagination() {
        if (isset($this->_pagination)) {
            return $this->_pagination;
        } else {
            return ' ';
        }
	}

    /**
     * @return array $_param_keys An array of columns to be modified.
     */
    final protected function _getParamKeys() {
        if (isset($this->_param_keys)) {
            return $this->_param_keys;
        } else {
            return false;
        }
    }

	/**
	 * @return array $_param_values An array of parameter values.
	 */
	final protected function _getParamValues() {
		if (isset($this->_param_values)) {
			return $this->_param_values;
		} else {
			return false;
		}
	}

    /**
     * @return string $_table
     * The currently selected table.
     */
    final protected function _getTable() {
        if (isset($this->_table)) {
            return $this->_table;
        } else {
            return false;
        }
    }

	/**
	 * @return string $_query The final query, with replaced placeholders,
	 * to be executed.
	 */
	final public function getQuery() {
		if (isset($this->_query)) {
			return $this->_query;
		} else {
			return false;
		}
	}

	/**
	 * @return array $_result The returned data from a SELECT query.
	 */
	final public function getResult() {
		if (isset($this->_result) && !empty($this->_result)) {
			return $this->_result;
		} else {
			return false;
		}
	}

	/**
	 * @param array $params An array of parameters to be modified or
	 * created by our prepared statement.
	 */
	final protected function _setParams($params) {
		$this->_param_keys = array_keys($params);
		$this->_param_values = array_values($params);
	}

    /**
     * @param array $columns An array of columns to be selected from a
     * SELECT query.
     */
    final protected function _setColumns($columns) {
        $this->_columns = $columns;
    }

	/**
	 * @param string $condition The WHERE clause.
	 * @param array $placeholders Contains the values of the placeholders
	 * in $condition for sanitization purposes, but is not required.
	 */
	final protected function _setCondition($condition, $placeholders = false) {
        if ($placeholders === false) {
            $this->_condition = 'where '.$condition;
        } else {
            foreach($placeholders as $k => $v) {
				$placeholders[$k] = '\''.filter_var($v, FILTER_SANITIZE_STRING).'\'';
			}
            $this->_condition = 'where '.str_replace(array_keys($placeholders), $placeholders, $condition);
        }
	}

	/**
	 * Determine the ordering of the query.
	 * @param array $ordering
	 */
	final public function setOrdering($ordering) {
		$order = isset($ordering['order']) ? $ordering['order'] : 'ASC';
		$order_by = isset($ordering['order_by']) ? $ordering['order_by'] : false;

		if ($order_by) {
			$this->_ordering = 'ORDER BY '.$order_by.' '.$order;
		}
	}

	/**
	 * Determine the limit and offset of the query
	 * @param array $pagination
	 */
	final public function setPagination($pagination) {
		$paged_exists = false;
		$limit_exists = false;

		if (is_array($pagination)) {
			$paged_exists = array_key_exists('paged', $pagination) ? $pagination['paged'] : false;
			$limit_exists = array_key_exists('limit', $pagination) ? $pagination['limit'] : false;
		}

		if ($paged_exists && $limit_exists) {
			$this->_pagination = 'LIMIT ' . (($pagination['paged'] - 1) * $pagination['limit']) . ', ' . $pagination['limit'];
		} elseif ($limit_exists) {
			$this->_pagination = 'LIMIT 0, ' . $pagination['limit'];
		}
	}

	/**
	 * @param string $query The query to be performed. This query may
     * include the following placeholders which simplify the process of
     * constructing an SQL query: {table}, {condition}, {columns},
     * {ordering}, {pagination}, {insert_columns}, {insert_values} and
     * {set_columns}.
	 */
	final protected function _setQuery($query) {
        $placeholders = array();

        if ($this->_getOrdering()) {
			$placeholders['{ordering}'] = $this->_getOrdering();
		}
        if ($this->_getCondition()) {
			$placeholders['{condition}'] = $this->_getCondition();
		}
        if ($this->_getPagination()) {
			$placeholders['{pagination}'] = $this->_getPagination();
		}
        if ($this->_getTable()) {
			$placeholders['{table}'] = $this->_getTable();
		}
		if (strpos($query, '{prefix}') !== false) {
			$placeholders['{prefix}'] = $this->_config['tableprefix'];
		}
        if (strpos($query, '{set_columns}') !== false) {
            $placeholders['{set_columns}'] = 'set '.implode(' = ?, ', $this->_getParamKeys()).' = ?';
		}
        if (strpos($query, '{insert_values}') !== false) {
            $placeholders['{insert_values}'] = 'value ('.rtrim(str_repeat('?, ', count($this->_getParamKeys())), ', ').')';
		}
        if (strpos($query, '{insert_columns}') !== false) {
            $placeholders['{insert_columns}'] = '('.implode(', ', $this->_getParamKeys()).')';
		}
        if (strpos($query, '{columns}') !== false) {
            $placeholders['{columns}'] = implode(', ', $this->_getColumns());
		}

        $this->_query = str_replace(array_keys($placeholders), array_values($placeholders), $query);
	}

	/**
	 * @param string $table The current table to be modified within
     * the database.
	 */
	final protected function _setTable($table) {
		$this->_table = $this->_config['tableprefix'] . $table;
	}

	/**
	 * Find a database resource based on the given condition.
	 */
	final public function find() {
		$this->_setQuery('select {columns} from {table} {condition} {ordering} {pagination}');
		$this->_execute();
	}

	final public function findById($id) {
		$this->_setCondition('id = #id', array('#id' => $id));
		$this->find();
	}

	/**
	 * Delete a database resource based on the given condition.
	 */
	final public function delete() {
		$this->_setQuery('delete from {table} {condition}');
		$this->_execute();
	}

	final public function deleteById($id) {
		$this->_setCondition('id = #id', array('#id' => $id));
		$this->_setQuery('delete from {table} {condition}');
		$this->_execute();
	}

	/**
	 * @param array $params Holds an array of values to be inserted into a
	 * single table row or multiple rows if using an associative array.
	 */
	public function create($params = null) {
		if ($params == null || !is_array($params)) {
			return false;
		}

		/**
		 * Since the insert function can accept multiple entries at once,
		 * we'll want to check rather or not $params is an associative array
		 * (meaning only one entry) or a numeric array (more than one entry).
		 * If it turns out to only be one entry, then we'll want to turn it
		 * into a multidimensional array to comply with the foreach loop.
		 */

		$all_params = (isset($params[0]) && is_array($params[0])) ? $params : array($params);

		foreach ($all_params as $params) {
			$this->_setParams($params);
			$this->_setQuery('insert into {table} {insert_columns} {insert_values}');
			$this->_execute();
		}
	}

	/**
	 * @param array $params Holds an array of values to be updated within a
	 * single table row. Unlike the insert function, this may not be an
	 * associative array.
	 */
	final public function update($params = null) {
		if (!isset($params) || !is_array($params))
			return false;
		$this->_setParams($params);
		$this->_setQuery('update {table} {set_columns} {condition}');
		$this->_execute();
	}

    /**
     * @param int $id
     * @param array $params Rows to be updated.
     */
	final public function updateById($id, $params = null) {
		$this->_setCondition('id = $1', array('$1' => $id));
		$this->update($params);
	}

    /**
     * Return the last inserted rows ID.
     * @return int _insert_id
     */
	final public function getInsertId() {
		if (!isset($this->_insert_id)) {
			$this->_insert_id = $this->db->lastInsertId();
		}
		return $this->_insert_id;
	}

    /**
     * Return the last inserted row.
     * @return array $result
     */
	final public function getInsertRow() {
		$this->_setQuery('select * from {table} {condition}');
		$this->_setCondition('id = $1', array('$1' => $this->getInsertId()));
		$this->_execute();
		$result = $this->getResult();
		return $result[0];
	}
}

?>
