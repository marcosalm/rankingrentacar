<?php
class Paginator {
	private $model;
	private $params;

	private $totalPages;
	private $totalFound;

	private $activePage;

	private $results;

	// html properties
	private $specificUrl = array();
	private $url = "";
	private $prevLabel = '« Anterior';
	private $nextLabel = 'Próximo »';
	private $template = "<li class='{active}'><a href='{url}'>{index}</a></li>";

	public function getModel() {
	    return $this->model;
	}
	
	public function setModel($newModel) {
	    $this->model = $newModel;
	}

	public function getParams() {
	    return $this->params;
	}
	
	public function setParams($newParams) {
	    $this->params = $newParams;
	}

	public function getTotalPages() {
	    return $this->totalPages;
	}
	
	public function setTotalPages($newTotalPages) {
	    $this->totalPages = $newTotalPages;
	}

	public function getTotalFound() {
	    return $this->totalFound;
	}
	
	public function setTotalFound($newTotalFound) {
	    $this->totalFound = $newTotalFound;
	}

	public function getActivePage() {
	    return $this->activePage;
	}
	
	public function setActivePage($newActivePage) {
	    $this->activePage = $newActivePage;
	}

	public function getResults() {
	    return $this->results;
	}
	
	public function setResults($newResults) {
	    $this->results = $newResults;
	}

	public function addSpecificUrl($index, $value) {
		$this->specificUrl[$index] = $value;
	}

	public function getUrl() {
	    return $this->url;
	}
	
	public function setUrl($newUrl) {
	    $this->url = $newUrl;
	}

	public function getPrevLabel() {
	    return $this->prevLabel;
	}
	
	public function setPrevLabel($newPrevLabel) {
	    $this->prevLabel = $newPrevLabel;
	}

	public function getNextLabel() {
	    return $this->nextLabel;
	}
	
	public function setNextLabel($newNext) {
	    $this->nextLabel = $newNext;
	}

	public function getTemplate() {
	    return $this->template;
	}
	
	public function setTemplate($newTemplate) {
	    $this->template = $newTemplate;
	}

	public function __construct($model, $params) {
		$this->model = $model;

		$posts_per_page = (isset($params['posts_per_page'])) ? $params['posts_per_page'] : get_option('posts_per_page');

		$this->params = $params;

		$page = isset($params['paged']) ? $params['paged'] : 1;
		$this->setActivePage($page);

		query_posts($params);

		$results = array();
		while (have_posts()) {
			the_post();
			global $post;
			$results[] = new $model($post);
		}

		$this->setResults($results);

		global $wp_query;

		$this->totalPages = $wp_query->max_num_pages;
		$this->totalFound = $wp_query->found_posts;
	}

	public function getHtml() {
		$output = "";

		if ($this->totalPages <= 1) return;

		$beforeHtml = '';
		$afterHtml = '';
		for ($i = 1; $i <= $this->totalPages; $i++) {
			$active =  '';
			if ($this->activePage == $i) {
				$active = 'active';
				if ($i > 1) {
					$beforeHtml .= $this->getTemplateHtml($this->prevLabel, $this->getUrlHtml(($i-1)));
				}
				if ($i < $this->totalPages) {
					$afterHtml .= $this->getTemplateHtml($this->nextLabel, $this->getUrlHtml(($i+1)));
				}
			}

			$output .= $this->getTemplateHtml($i, $this->getUrlHtml($i), $active);
		}

		return $beforeHtml . $output . $afterHtml;
	}

	public function getUrlHtml($index) {
		$url = $this->url;

		if (isset($this->specificUrl[$index])) {
			$url = $this->specificUrl[$index];
		}

		// parsing url html
		$url = str_replace('{index}', $index, $url);

		return $url;
	}

	public function getTemplateHtml($index, $url, $active = '') {
		$output = $this->getTemplate();

		// parse template
		$output = str_replace('{index}', $index, $output);
		$output = str_replace('{url}', $url, $output);
		$output = str_replace('{active}', $active, $output);

		return $output;
	}
}