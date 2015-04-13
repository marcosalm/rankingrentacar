<?php
class Image {
	private $src;

	public function getSrc() {
	    return $this->src;
	}
	
	public function setSrc($newSrc) {
	    $this->src = $newSrc;
	}

	public function __construct($src = false) {
		if ($src) $this->setSrc($src);
	}

	public function getResizedSrc($width, $height, $outputMode = 'landscape') {
        $src = $this->getSrc();
        $uri = str_replace(GD_BASE_URL, '', $src);

        return GD::mountSrc($uri, $width, $height, $outputMode);
    }
}