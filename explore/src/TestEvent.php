<?php

namespace Drupal\explore;

use Symfony\Component\EventDispatcher\Event;

class TestEvent extends Event {

  const SUBMIT = 'event.submit';

  protected $referenceID;

  public function __construct($referenceID) {
    $this->referenceID = $referenceID;
  }

  public function getReferenceID() {
    return $this->referenceID;
  }

  public function myEventDescription() {
    return "This is as an example event";
  }

}
