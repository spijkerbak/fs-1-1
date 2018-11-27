<?php

require_once 'FSBase.php';

class File extends FSBase {

    function __construct() {
        $args = func_get_args();
        if (count($args) === 1 && is_array($args[0])) {
            parent::__construct($args[0]);
        } else {
            parent::__construct(func_get_args());
        }
    }

    function exists() {
        return file_exists($this->path);
    }

    function open($mode) {
        if ($mode == 'r' && !$this->exists()) {
            $this->handle = false;
        } else {
            $this->handle = fopen($this->path, $mode);
        }
        return $this->handle !== false;
    }

    function close() {
        fclose($this->handle);
    }

    function write($text) {
        fwrite($this->handle, $text);
    }

    function gets() {
        return fgets($this->handle);
    }

    function readfile() {
        readfile($this->path);
    }

}
