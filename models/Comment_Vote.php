<?php 

class Comment_Vote {
    private $_id_comment;
    private $_id_user;
    private $_value;

    public function __construct($id_comment, $id_user, $value) {
        $this->setCommentId($id_comment);
        $this->setUserId($id_user);
        $this->setValue($value);
    }

    public function getCommentId() {
        return $this->_id_comment;
    }

    public function setCommentId($id_comment) {
        $this->_id_comment = $id_comment;
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

        $array["id_comment"] = $this.getCommentId();
        $array["id_user"] = $this->getUserId();
        $array["value"] = $this->getValue();

        return $array;
    }
}

?>