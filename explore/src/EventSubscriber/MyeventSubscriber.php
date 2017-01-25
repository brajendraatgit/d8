<?php

namespace Drupal\explore\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Drupal\explore\TestEvent;

/**
 * Class MyeventSubscriber.
 *
 * @package Drupal\test
 */
class MyeventSubscriber implements EventSubscriberInterface {


  /**
   * Constructor.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  static function getSubscribedEvents() {
    $events = array();
    $events[TestEvent::SUBMIT][] = array('doSomeAction', 800);
    return $events; 
  }
  
  /**
   * Subscriber Callback for the event.
   * @param ExampleEvent $event
   */
  public function doSomeAction(TestEvent $event) {
    drupal_set_message("The Example Event has been subscribed, which has bee dispatched on submit of the form with " . $event->getReferenceID() . " as Reference");
  }

}
