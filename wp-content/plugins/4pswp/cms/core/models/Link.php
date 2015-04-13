<?php
class Link extends Model {

	private $id;
    private $url;
    private $name;
    private $image;
    private $target;
    private $description;
    private $visible;
    private $owner;
    private $rating;
    private $updated;
    private $rel;
    private $notes;
    private $rss;

    private $categoryId;

    public function getId() {
        return $this->id;
    }

    public function setId($newId) {
        $this->id = $newId;
    }

	public function getUrl() {
	    return $this->url;
	}

	public function setUrl($newUrl) {
	    $this->url = $newUrl;
	}

	public function getName() {
	    return $this->name;
	}

	public function setName($newName) {
	    $this->name = $newName;
	}

	public function getImage() {
	    return $this->image;
	}

	public function setImage($newImage) {
	    $this->image = $newImage;
	}

	public function getTarget() {
	    return $this->target;
	}

	public function setTarget($newTarget) {
	    $this->target = $newTarget;
	}

	public function getDescription() {
	    return $this->description;
	}

	public function setDescription($newDescription) {
	    $this->description = $newDescription;
	}

	public function getVisible() {
	    return $this->visible;
	}

	public function setVisible($newVisible) {
	    $this->visible = $newVisible;
	}

	public function getOwner() {
	    return $this->owner;
	}

	public function setOwner($newOwner) {
	    $this->owner = $newOwner;
	}

	public function getRating() {
	    return $this->rating;
	}

	public function setRating($newRating) {
	    $this->rating = $newRating;
	}

	public function getUpdated() {
	    return $this->updated;
	}

	public function setUpdated($newUpdated) {
	    $this->updated = $newUpdated;
	}

	public function getRel() {
	    return $this->rel;
	}

	public function setRel($newRel) {
	    $this->rel = $newRel;
	}

	public function getNotes() {
	    return $this->notes;
	}

	public function setNotes($newNotes) {
	    $this->notes = $newNotes;
	}

	public function getRss() {
	    return $this->rss;
	}

	public function setRss($newRss) {
	    $this->rss = $newRss;
	}

	public function getCategoryId() {
	    return $this->categoryId;
	}
	
	public function setCategoryId($newCategoryId) {
	    $this->categoryId = $newCategoryId;
	}

	public static function find($params = false) {
		$defaultParams = array(
			'orderby' => 'id'
		);

		$finalParams = ($params && is_array($params)) ? array_merge($defaultParams, $params) : $defaultParams;

		$links = get_bookmarks($finalParams);

		$results = array();
		
		foreach ($links as $link) {
			$results[] = new Link($link);
		}

		return $results;
	}

	public function load($object) {
		parent::load($object, 'link');
	}
}