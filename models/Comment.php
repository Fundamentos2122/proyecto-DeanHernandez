<?php 

class Comment {

    private $_id_post;
    private $_id_user;
    private $_username;
    private $_id_comment;
    private $_rating;
    private $_text;
    private $_created_at;
    private $_updated_at;
    private $_active;

    public function __construct($id_comment, $id_user, $username, $id_post, $text, $rating, $created_at, $updated_at, $active) {
        $this->setPostId($id_post);
        $this->setUserId($id_user);
        $this->setUsername($username);
        $this->setCommentId($id_comment);
        $this->setRating($rating);
        $this->setText($text);
        $this->setCreated_at($created_at);
        $this->setUpdated_at($updated_at);
        $this->setActive($active);
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

    public function getUsername() {
        return $this->_username;
    }

    public function setUsername($username) {
        $this->_username = $username;
    }

    public function getCommentId() {
        return $this->_id_comment;
    }

    public function setCommentId($id_comment) {
        $this->_id_comment = $id_comment;
    }

    public function getRating() {
        return $this->_rating;
    }

    public function setRating($rating) {
        $this->_rating = $rating;
    }

    public function getText() {
        return $this->_text;
    }

    public function setText($text) {
        $this->_text = $text;
    }

    public function getCreated_at() {
        return $this->_created_at;
    }

    public function setCreated_at($created_at) {
        $this->_created_at = $created_at;
    }

    public function getUpdated_at() {
        return $this->_updated_at;
    }

    public function setUpdated_at($updated_at) {
        $this->_updated_at = $updated_at;
    }

    public function getActive() {
        return $this->_active;
    }

    public function setActive($active) {
        $this->_active = $active;
    }

    public function getArray() {
        $array = array();

        $array["id_comment"] = $this->getCommentId();
        $array["id_user"] = $this->getUserId();
        $array["username"] = $this->getUsername();
        $array["id_post"] = $this->getPostId();
        $array["text"] = $this->getText();
        $array["rating"] = $this->getRating();
        $array["created_at"] = $this->getCreated_at();
        $array["updated_at"] = $this->getUpdated_at();
        $array["active"] = $this->getActive();

        return $array;
    }
}

?>