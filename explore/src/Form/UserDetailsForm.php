<?php

namespace Drupal\explore\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\explore\TestEvent;
use Drupal\explore\ExploreStorage;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Datetime\Entity\DateFormat;

/**
 * Class UserDetailsForm.
 *
 * @package Drupal\explore\Form
 */
class UserDetailsForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_details_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#maxlength' => 64,
      '#size' => 64,
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#maxlength' => 64,
      '#size' => 64,
    ];
    $form['dob'] = [
      '#type' => 'datetime',
      '#title' => $this->t('DOB'),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }
    $date = new DrupalDateTime($form_state->getValue('dob'), DATETIME_STORAGE_TIMEZONE);
    $date_format = DateFormat::load('html_date')->getPattern();
    
    $entry = array(
      'first_name' => $form_state->getValue('first_name'),
      'last_name' => $form_state->getValue('last_name'),
      'dob' => strtotime($date->format($date_format)),
    );
    $return = ExploreStorage::insert($entry);
    if ($return) {
      drupal_set_message(t('Created entry @entry', array('@entry' => print_r($entry, TRUE))));
    }
    
    
    // Following is the example for
    // How to dispatch an event in Drupal 8?
    $dispatcher = \Drupal::service('event_dispatcher');
    $event = new TestEvent($form_state->getValue('first_name'));
    $dispatcher->dispatch(TestEvent::SUBMIT, $event);

  }

}
