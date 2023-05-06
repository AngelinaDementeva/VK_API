<?php

class Event {
  private $id;
  private $name;
  private $status;
  private $created_at;
  private $ip_address;

  public function __construct($name, $status, $ip_address) {
    $this->name = $name;
    $this->status = $status;
    $this->created_at = date('Y-m-d H:i:s');
    $this->ip_address = $ip_address;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function getIpAddress() {
    return $this->ip_address;
  }
}
