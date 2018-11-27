<?php
 
require_once 'FSBase.php';

class Folder extends FSBase {

    function __construct() {
        parent::__construct(func_get_args());
    }

    function exists() {
        return is_dir($this->path);
    }

    function open() {
        if (!is_dir($this->path)) {
            $this->handle = false;
        } else {
            $this->handle = opendir($this->path);
        }
        return $this->handle !== false;
    }

    function read() {
        return readdir($this->handle);
    }

    function close() {
        closedir($this->handle);
    }

    function create() {
        mkdir($this->path);
    }

}
