<?php

namespace Drupal\explore\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\explore\TestEvent;

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
      '#type' => 'date',
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
    // Following is the example for
    // How to dispatch an event in Drupal 8?
    $dispatcher = \Drupal::service('event_dispatcher');
    $event = new TestEvent($form_state->getValue('first_name'));
    $dispatcher->dispatch(TestEvent::SUBMIT, $event);

  }

}
