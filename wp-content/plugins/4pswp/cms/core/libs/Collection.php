<?php
class Collection {
    private $buffer = array();

    public function getBuffer() {
        return $this->buffer;
    }
    
    public function setBuffer($newBuffer) {
        $this->buffer = $newBuffer;
    }
    
    public function set($key, $value) {
        $this->buffer[$key] = $value;
    }
    
    public function get($key) {
        if ($this->has($key))
            return $this->buffer[$key];
        return false;
    }

    public function has($key) {
    	return isset($this->buffer[$key]);
    }

    public function remove($key) {
        $value = $this->get($key);
        unset($this->buffer[$key]);
        return $value;
    }
}