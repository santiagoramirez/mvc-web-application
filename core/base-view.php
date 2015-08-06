<?php

class View
{
	private $_page;
	private $_tpl_path;
	private $_helper_path;
	private $_subdir;

	/**
	 * Determine the current page to be rendered.
	 * @return string $_page
	 */
	private function _getCurrentPage() {
		if (!isset($this->_page)) {
			$this->_page = isset($_GET['page']) ? $_GET['page'] : false;
			if ($this->_page == false) {
				$this->_page = 'home';
			}
		}
		return $this->_page;
	}

	/**
	 * Forces the application to use templates contained in a subdirectory.
	 * @param string $subdir
	 */
	public function setSubdirectory($subdir) {
		if (isset($subdir)) {
			$this->_subdir = $subdir;
		} else {
			return;
		}
	}

    /**
     * Return the current template subdirectory if one exists.
     * @return false|string $_subdir
     * @see View::setSubdirectory()
     */
    private function _getSubdirectory() {
        if (isset($this->_subdir)) {
            return $this->_subdir;
        } else {
            return false;
        }
    }

	/**
	 * Locate the path of a .tpl file from the /templates folder which
	 * corresponds with the current page.
	 * @return false|string $_tpl_path
	 */
	private function _getTemplatePath() {
		if (!isset($this->_tpl_path)) {
			$page = $this->_getCurrentPage();
			$subdir = $this->_getSubdirectory();
			$tpl_root = ($subdir) ? TEMPLATES_ROOT.'/'.$subdir : TEMPLATES_ROOT;
			$tpl_path = $tpl_root.'/'.$page.'.tpl';

			if (file_exists($tpl_path)) {
				$this->_tpl_path = $tpl_path;
			} else {
				$this->_tpl_path = false;
			}
		}
		return $this->_tpl_path;
	}

	/**
	 * Locate the path of the helper which corresponds with the current page.
	 * The code contained in the helper file is responsible for preparing
	 * data/variables for the .tpl template.
	 * @return false|string $_helper_path
	 */
	private function _getHelperPath() {
		if (!isset($this->_helper_path)) {
			$view = str_replace('/', '-', $this->_getCurrentPage());
			$subdir = $this->_getSubdirectory();
			$root = ($subdir) ? HELPERS_ROOT.'/'.$subdir : HELPERS_ROOT;
			$helper_path = $root.'/'.$view.'.php';

			if (file_exists($helper_path)) {
				$this->_helper_path = $helper_path;
			} else {
				$this->_helper_path = false;
			}
		}
		return $this->_helper_path;
	}

	/**
	 * Let's render our page!
	 */
	public function render() {
		$tpl_path = $this->_getTemplatePath();
		$current_page = $this->_getCurrentPage();
		$current_url = DOMAIN_ROOT.'/'.$current_page;
		$template_dir = str_replace('/'.$current_page.'.tpl', '', $tpl_path);

		if (!$this->_getTemplatePath()) {
			$this->redirectTo('404');
		}

		$smarty = new Smarty();
		$smarty->assign('current_page', $current_page);
		$smarty->assign('current_url', $current_url);
		$smarty->assign('domain_root', DOMAIN_ROOT);
		$smarty->assign('template_dir', $template_dir);

		if (file_exists($this->_getHelperPath())) {
			require_once $this->_getHelperPath();
		}

		$smarty->display($this->_getTemplatePath());
	}
}

?>
