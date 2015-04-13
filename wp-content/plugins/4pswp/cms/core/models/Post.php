<?php

class Post extends Model {

	private $id;
	private $author;
	private $date;
	private $dateGmt;
	private $content;
	private $parsedContent;
	private $title;
	private $excerpt;
	private $status;
	private $commentStatus;
	private $pingStatus;
	private $password;
	private $name;
	private $toPing;
	private $pinged;
	private $modified;
	private $modifiedGmt;
	private $contentFiltered;
	private $parent;
	private $guid;
	private $menuOrder;
	private $type;
	private $mimeType;
	private $commentCount;
	private $filter;

	public function getId() {
		return $this->id;
	}

	public function setId($newId) { 
		$this->id = $newId;
	}

	public function getAuthor() {
		return $this->author;
	}

	public function setAuthor($newAuthor) {
		$this->author = $newAuthor;
	}

	public function getDate($format = false) {
		if ($format)
			return date($format, strtotime($this->date));

		return $this->date;
	}

	public function setDate($newDate) {
		$this->date = $newDate;
	}

	public function getDateGmt() {
		return $this->dateGmt;
	}

	public function setDateGmt($newDateGmt) {
		$this->dateGmt = $newDateGmt;
	}

	public function getContent($parsed = false) {
		if ($parsed) {
			$content = apply_filters('the_content', $this->content);
			$content = str_replace(']]>', ']]&gt;', $content);
			return $content;
		}

		return $this->content;
	}

	public function setContent($newContent) {
		$this->content = $newContent;
	}

	public function getParsedContent() {
		return $this->parsedContent;
	}

	public function setParsedContent($newContent) {
		$this->parsedContent = $newContent;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($newTitle) {
		$this->title = $newTitle;
	}

	public function getExcerpt() {
		return $this->excerpt;
	}

	public function setExcerpt($newExcerpt) {
		$this->excerpt = $newExcerpt;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($newStatus) {
		$this->status = $newStatus;
	}

	public function getCommentStatus() {
		return $this->commentStatus;
	}

	public function setCommentStatus($newCommentStatus) {
		$this->commentStatus = $newCommentStatus;
	}

	public function getPingStatus() {
		return $this->pingStatus;
	}

	public function setPingStatus($newPingStatus) {
		$this->pingStatus = $newPingStatus;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($newPassword) {
		$this->password = $newPassword;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($newName) {
		$this->name = $newName;
	}

	public function getToPing() {
		return $this->toPing;
	}

	public function setToPing($newToPing) {
		$this->toPing = $newToPing;
	}

	public function getPinged() {
		return $this->pinged;
	}

	public function setPinged($newPinged) {
		$this->pinged = $newPinged;
	}

	public function getModified() {
		return $this->modified;
	}

	public function setModified($newModified) {
		$this->modified = $newModified;
	}

	public function getModifiedGmt() {
		return $this->modifiedGmt;
	}

	public function setModifiedGmt($newModifiedGmt) {
		$this->modifiedGmt = $newModifiedGmt;
	}

	public function getContentFiltered() {
		return $this->contentFiltered;
	}

	public function setContentFiltered($newContentFiltered) {
		$this->contentFiltered = $newContentFiltered;
	}

	public function getParent() {
		return $this->parent;
	}

	public function setParent($newParent) {
		$this->parent = $newParent;
	}

	public function getGuid() {
		return $this->guid;
	}

	public function setGuid($newGuid) {
		$this->guid = $newGuid;
	}

	public function getMenuOrder() {
		return $this->menuOrder;
	}

	public function setMenuOrder($newMenuOrder) {
		$this->menuOrder = $newMenuOrder;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($newType) {
		$this->type = $newType;
	}

	public function getMimeType() {
		return $this->mimeType;
	}

	public function setMimeType($newMimeType) {
		$this->mimeType = $newMimeType;
	}

	public function getCommentCount() {
		return $this->commentCount;
	}

	public function setCommentCount($newCommentCount) {
		$this->commentCount = $newCommentCount;
	}

	public function getFilter() {
		return $this->filter;
	}

	public function setFilter($newFilter) {
		$this->filter = $newFilter;
	}

	public function getPermalink() {
		return get_permalink($this->getId());
	}

	public function getThumbnail($size = 'full') {
		return self::findThumbnail($this->getId(), $size);
	}

	public function getThumbnailSrc() {
		$thumbnail = $this->getThumbnail();
		return ($thumbnail) ? $thumbnail->getSrc() : '';
	}

	public function getThumbnailSrcResized($width, $height, $forced = false) {
		$thumbnail = $this->getThumbnail();
		if ($thumbnail) {
			return $thumbnail->getResizedSrc($width, $height);
		} else if ($forced) {
			return GD::getDefaultSrc($width, $height);
		}
		return '';
	}

	public function load($post) {
		$this->setId($post->ID);
		$this->setCommentStatus($post->comment_status);
		$this->setPingStatus($post->ping_status);
		$this->setToPing($post->to_ping);
		$this->setPinged($post->pinged);
		$this->setGuid($post->guid);
		$this->setMenuOrder($post->menu_order);
		$this->setCommentCount($post->comment_count);
		$this->setFilter($post->filter);
		parent::load($post, 'post');
	}

	public static function find($params = false, $className = 'Post') {
		if (!$params) {
			global $post;
			return new Post($post);
		}

		$defaultParams = array(
			'orderby' => 'id',
			'post_type' => 'post'
			);

		$finalParams = ($params && is_array($params)) ? array_merge($defaultParams, $params) : $defaultParams;

		$posts = get_posts($finalParams);

		$results = array();

		foreach ($posts as $post) {
			$object = new $className($post);
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

	public static function findById($id) {
		$post = get_post($id);

		if ($post)
			return new Post($post);

		return false;
	}

	public static function findThumbnail($id, $size = 'full') {
		$guid = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
		if ($guid) {
			$src = current($guid);
			return new Image($src);
		}
		return false;
	}

	public static function getProtectedPostsIds() {
		global $wpdb;
		$result = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_password <> ''", OBJECT);
		$ids = array();
		foreach ($result as $post) {
			$ids[] = $post->ID;
		}
		return $ids;
	}

	public function getCustomField($name) {
		if ( !function_exists('get_field') )  { return false; }

		$field = get_field( $name, $this->getId() );
		return !empty($field) ? $field : false;
	}

	public static function getCustomFieldData($post_id, $name, $field = 'label') {
		global $wpdb;

		if ( function_exists('get_field') ) {
			$result = $wpdb->get_results("
				SELECT meta_value 
				FROM wp_postmeta 
				WHERE meta_key = (SELECT meta_value FROM wp_postmeta WHERE meta_key = '_{$name}' AND post_id = {$post_id})
			");

			if (count($result) > 0) {
				$object = current($result);
					if ( is_object($object) ) {
					$serial = $object->meta_value;
					$data   = maybe_unserialize($serial);

					return $data[ $field ];
				}
			}
		}

		return false;
	}
}