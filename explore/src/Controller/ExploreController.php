<?php

namespace Drupal\explore\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\explore\ExploreStorage;
use Drupal\Component\Utility\SafeMarkup;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Controller for DBTNG Example.
 */
class ExploreController extends ControllerBase {

  /**
   * Render a list of entries in the database.
   */
  public function entryList() {
    $content = array();

    $content['message'] = array(
      '#markup' => $this->t('Generate a list of all entries in the database. There is no filter in the query.'),
    );

    $rows = array();
    $headers = array(t('uid'), t('First Name'), t('Last Name'), t('Dob'), t('Operations'));

    foreach ($entries = ExploreStorage::load() as $entry) {
      // Sanitize each entry.
      //$rows[] = array_map('Drupal\Component\Utility\SafeMarkup::checkPlain', (array) $entry);
      $row = array();
      foreach ($entry as $key => $value) {
        if ($key == 'dob') {
          $row[$key] = SafeMarkup::checkPlain(format_date($value, 'short'));
        }
        else {
          $row[$key] = SafeMarkup::checkPlain($value);
        }
      }
      
      $db = [
        '#type' => 'dropbutton',
        '#links' => [
          'a' => [
            'title' => $this->t('Edit'),
            'url' => Url::fromRoute('explore.user_details_update', array('uid' => $row['uid'])),
          ],
          'b' => [
            'title' => $this->t('Delete'),
            'url' => Url::fromRoute('explore.user_details_form'),
          ],
        ],
      ];
      $row['op'] = \Drupal::service('renderer')->render($db);
      $rows[] = $row;
    }
    $content['table'] = array(
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#empty' => t('No entries available.'),
    );
    // Don't cache this page.
    $content['#cache']['max-age'] = 0;

    return $content;
  }

  /**
   * Render a filtered list of entries in the database.
   */
  public function entryAdvancedList() {
    $content = array();

    $content['message'] = array(
      '#markup' => $this->t('A more complex list of entries in the database.') . ' ' .
      $this->t('Only the entries with name = "John" and age older than 18 years are shown, the username of the person who created the entry is also shown.'),
    );

    $headers = array(
      t('Id'),
      t('Created by'),
      t('Name'),
      t('Surname'),
      t('Age'),
    );

    $rows = array();
    foreach ($entries = DbtngExampleStorage::advancedLoad() as $entry) {
      // Sanitize each entry.
      $rows[] = array_map('Drupal\Component\Utility\SafeMarkup::checkPlain', $entry);
    }
    $content['table'] = array(
      '#type' => 'table',
      '#header' => $headers,
      '#rows' => $rows,
      '#attributes' => array('id' => 'dbtng-example-advanced-list'),
      '#empty' => t('No entries available.'),
    );
    // Don't cache this page.
    $content['#cache']['max-age'] = 0;
    return $content;
  }

}
