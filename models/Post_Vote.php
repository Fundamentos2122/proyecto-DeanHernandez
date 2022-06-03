<?php 

class Post_Vote {
    private $_id_post;
    private $_id_user;
    private $_value;

    public function __construct($id_post, $id_user, $value) {
        $this->setPostId($id_post);
        $this->setUserId($id_user);
        $this->setValue($value);
    }

    public function getPostId() {
        return $this->_id_post;
    }

    public function setPostId($id_post) {
        $this->_id_post = $id_post;
    }

    public function getUserId() {
        return $this->_id_user;
    }

    public function setUserId($id_user) {
        $this->_id_user = $id_user;
    }
    
    public function getValue() {
        return $this->_value;
    }

    public function setValue($value) {
        $this->_value = $value;
    }

    public function getArray() {
        $array = array();

        $array["id_post"] = $this->getPostId();
        $array["id_user"] = $this->getUserId();
        $array["value"] = $this->getValue();

        return $array;
    }
}

?>