<?php
class Category extends Model {
	private $id;
	private $name;
	private $description;
	private $parentId;
	private $count;
	private $nicename;

	public function getId() {
	    return $this->id;
	}
	
	public function setId($newId) {
	    $this->id = $newId;
	}

	public function getName() {
	    return $this->name;
	}
	
	public function setName($newName) {
	    $this->name = $newName;
	}

	public function getDescription() {
	    return $this->description;
	}
	
	public function setDescription($newDescription) {
	    $this->description = $newDescription;
	}

	public function getParentId() {
	    return $this->parentId;
	}
	
	public function setParentId($newParentId) {
	    $this->parentId = $newParentId;
	}

	public function getCount() {
	    return $this->count;
	}
	
	public function setCount($newCount) {
	    $this->count = $newCount;
	}

	public function getNicename() {
	    return $this->nicename;
	}
	
	public function setNicename($newNicename) {
	    $this->nicename = $newNicename;
	}

	public function getSlug() {
		return $this->getNicename();
	}

	public function load($object) {
		parent::load($object, 'category');
	}

	public static function find($params = false, $className = 'Category') {
		$defaultParams = array(
			'orderby' => 'id'
		);

		$finalParams = ($params && is_array($params)) ? array_merge($defaultParams, $params) : $defaultParams;

		$categories = get_categories($finalParams);

		$results = array();
		
		foreach ($categories as $category) {
			$object = new $className($category);
			$object->setId($category->cat_ID);
			$object->setName($category->name);
			$object->setParentId($category->parent);

			$results[] = $object;
		}

		return $results;
	}

	public static function findFirst($params = false) {
        $posts = self::find($params);

        if (sizeof($posts))
            return current($posts);

        return false;
    }
}