<?php

namespace Drupal\explore\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ExploreConfigForm.
 *
 * @package Drupal\explore\Form
 */
class ExploreConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'explore.exploreconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'explore_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('explore.exploreconfig');
    $form['enter_site_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Site Name'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('enter_site_name'),
    ];
    return parent::buildForm($form, $form_state);
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
    parent::submitForm($form, $form_state);

    $this->config('explore.exploreconfig')
      ->set('enter_site_name', $form_state->getValue('enter_site_name'))
      ->save();
  }

}
