<?php

/**
 * This is the Controller abstract class. It is resposible for processing
 * requests and turning data over to the databse.
 *
 * @author Santiago Ramirez
 * @link http://santiagoramirez.net
 * @link https://github.com/santiagoramirez
 */

abstract class Controller
{
	/**
	 * The maximum number of entries to be returned for any given request.
	 * @const integer
	 */
	const MAX_POSTS_PER_PAGE = 100;

	/**
	 * Contains an array of error strings.
	 * @var string
	 * @see reportError()
	 */
	protected $_errors = array();

	/**
	 * An array of parameters to be extracted from the request.
	 * @var array
	 */
	protected $_params = array();

	/**
	 * An associative array of extracted request parameters which have not yet
	 * been filtered of possibly harmful code.
	 *
	 * @var array
	 * @see _getUnfilteredParams()
	 */
	protected $_params_unfiltered = array();

	/**
	 * An associative array of extracted request parameter which HAVE been
	 * filtered of possibly harmful code.
	 *
	 * @var array
	 * @see _getFilteredParams()
	 */
	protected $_params_filtered = array();

	/**
	 * Contains an associative array with two keys ('order' and 'order_by').
	 * @var array $_ordering
	 * @see getOrdering()
	 */
	protected $_ordering;

	/**
	 * Contains an associative array with two keys ('limit' and 'page').
	 * @var array $_pagination
	 * @see getPagination()
	 */
	protected $_pagination;

	/**
	 * Return the value of a $_REQUEST variable in a safe manner.
	 * If the value is not set, the value will be returned as false.
	 *
	 * @param string $var The array key of a $_REQUEST variable
	 * @return string|false
	 */
	final protected function _getRequestVar($var) {
		if (isset($_REQUEST[$var])) {
			return $_REQUEST[$var];
		} else {
			return false;
		}
	}

	/**
	 * Extract the parameters set in the $_params array from the current
	 * request. Unset request parameters are marked as false.
	 *
	 * @return array $_params_unfiltered
	 */
	final protected function _getUnfilteredParams() {
		if (empty($this->_params_unfiltered)) {
			foreach ($this->_params as $param) {
				$this->_params_unfiltered[$param] = $this->_getRequestVar($param);
			}
		}
		return $this->_params_unfiltered;
	}

	/**
	 * Filter/sanitize the extracted parameters of _getUnfilteredParams()
	 * This function may be overwritten by its children in order to filter
	 * certain parameters more thoroughly.
	 *
	 * @return array $_params_filtered
	 */
	protected function _getFilteredParams() {
		if (empty($this->params_filtered)) {
			$unfiltered = $this->_getUnfilteredParams();
			foreach($unfiltered as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $kk => $vv) {
						if (is_array($vv)) {
							foreach ($vv as $kkk => $vvv) {
								$this->_params_filtered[$k][$kk][$kkk] = $this->_filterParam($vvv);
							}
						} else {
							$this->_params_filtered[$k][$kk] = $this->_filterParam($vv);
						}
					}
				} else {
					$this->_params_filtered[$k] = $this->_filterParam($v);
				}
			}
		}
		return $this->_params_filtered;
	}

	/**
	 * Filter a single parameter.
	 * @param string $value
	 * @return string $value_filtered
	 */
	final protected function _filterParam($value) {
		$value_filtered = filter_var($value, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		return $value_filtered;
	}

	/**
	 * This function is pretty much the same as _getFilteredParams(), but with
	 * two exceptions: (1) It can be called publicly and (2) it removes unset
	 * request parameters.
	 *
	 * @return array $params
	 */
	final public function getParams() {
		$params = $this->_getFilteredParams();
		foreach ($params as $k => $v) {
			if ($v == false) {
				unset($params[$k]);
			}
		}
		return $params;
	}

	/**
	 * Change the value of a specific parameter.
	 * @param string $key
	 * @param string $value
	 */
	final protected function _setParam($key, $value) {
		$this->_params_filtered[$key] = $this->_filterParam($value);
		$this->_params_unfiltered[$key] = $value;
	}

	/**
	 * Extracts 'order' and 'order_by' from the current request and returns
	 * the result as an array. This array is meant to be passed to the method
	 * setOrdering($ordering) in the Model class.
	 *
	 * @return array $_ordering
	 */
	final protected function _getOrdering() {
		if (!isset($this->_ordering)) {
			$order = (isset($_REQUEST['order'])) ? $_REQUEST['order'] : false;
			$order_by = (isset($_REQUEST['order_by'])) ? $_REQUEST['order_by'] : false;
			if ($order) {
				$this->_ordering['order'] = filter_var($order, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			}
			if ($order_by) {
				$this->_ordering['order_by'] = filter_var($order_by, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			}
			return $this->_ordering;
		}
	}

	/**
	 * Extracts 'paged' and 'limit' from the current request and returns the
	 * result as an array. This array is meant to be passed to the method
	 * setPagination($pagination) in the Model class.
	 *
	 * @return array $_pagination
	 */
	final protected function _getPagination() {
		if (!isset($this->_pagination)) {
			$paged = (isset($_REQUEST['paged'])) ? intval($_REQUEST['paged']) : false;
			$limit = (isset($_REQUEST['limit'])) ? intval($_REQUEST['limit']) : self::MAX_POSTS_PER_PAGE;
			if ($paged) {
				$this->_pagination['paged'] = $_REQUEST['paged'];
			}
			if ($limit) {
				$this->_pagination['limit'] = ($limit > self::MAX_POSTS_PER_PAGE) ? self::MAX_POSTS_PER_PAGE : $limit;
			}
			return $this->_pagination;
		}
	}

	/**
	 * This function is used primarily to report validation errors, but may
	 * serve other purposes as well.
	 *
	 * @example $this->_reportError('invalid_email')
	 * @example $this->_reportError('password_do_not_match')
	 * @param mixed $error
	 */
	final protected function _reportError($error) {
		$this->_errors[] = $error;
	}

	/**
	 * Return the $_errors array.
	 * @see _reportError()
	 * @return array $_errors
	 */
	final public function getErrors() {
		if (empty($this->_errors)) {
			return false;
		} else {
			return $this->_errors;
		}
	}
}

?>
