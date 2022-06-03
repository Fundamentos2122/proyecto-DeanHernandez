<?php 

class Post {

    private $_id_post;
    private $_id_user;
    private $_username;
    private $_photo;
    private $_rating;
    private $_title;
    private $_text;
    private $_created_at;
    private $_updated_at;

    public function __construct($id_post, $id_user, $username, $text, $title, $photo, $rating, $created_at, $updated_at) {
        $this->setPostId($id_post);
        $this->setUserId($id_user);
        $this->setUsername($username);
        $this->setPhoto($photo);
        $this->setRating($rating);
        $this->setTitle($title);
        $this->setText($text);
        $this->setCreated_at($created_at);
        $this->setUpdated_at($updated_at);
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

    public function getPhoto() {
        return $this->_photo;
    }

    public function setPhoto($photo) {
        $this->_photo = base64_encode($photo);
    }

    public function getRating() {
        return $this->_rating;
    }

    public function setRating($rating) {
        $this->_rating = $rating;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function setTitle($title) {
        $this->_title = $title;
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

    public function getArray() {
        $array = array();

        $array["id_post"] = $this->getPostId();
        $array["id_user"] = $this->getUserId();
        $array["username"] = $this->getUsername();
        $array["text"] = $this->getText();
        $array["title"] = $this->getTitle();
        $array["photo"] = $this->getPhoto();
        $array["rating"] = $this->getRating();
        $array["created_at"] = $this->getCreated_at();
        $array["updated_at"] = $this->getUpdated_at();

        return $array;
    }
}

?>