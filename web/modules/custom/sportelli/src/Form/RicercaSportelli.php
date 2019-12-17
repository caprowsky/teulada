<?php
/**
 * @file
 * Contains \Drupal\sportelli\Form\RicercaSportelli.
 */

namespace Drupal\sportelli\Form;
use Drupal\sportelli;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
use SoapClient;
use SoapVar;
use SoapHeader;
use SoapFault;
use stdClass;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CommandInterface;
use Drupal\Core\Ajax\HtmlCommand;

use Drupal\Core\Cache\CacheBackendInterface;
/**
 * Contribute form.
 */
class RicercaSportelli extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sportelli_ricerca_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $comuni_get = \Drupal::cache()->get('sportelli_comuni');


    if (!$comuni_get) {
      $comuni = \Drupal::service('sportelli.utils')->getComuni();
      //$comuni = \Drupal::cache()->set('sportelli_comuni', $comuni, CacheBackendInterface::CACHE_PERMANENT, array('sportelli'));

    }
    else {
      $comuni = $comuni_get->data;
    }

    $string = t('Select a city');
    array_unshift($comuni, $string);

    $form['#suffix'] = '<div id="sportelli-list"></div>';

    $form['comune'] = [
      '#type' => 'select',
      '#options' => $comuni,
      '#title' => t('City'),
      '#ajax' => [
        'callback' => 'Drupal\sportelli\Form\RicercaSportelli::sportelliSearchCallback',
        'event' => 'change',
      ]
    ];

    /*$form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
      '#ajax' => [
        'callback' => 'Drupal\sportelli\Form\RicercaSportelli::sportelliSearchCallback',
        'event' => 'click',
      ]
    ];*/
    return $form;
  }

  public function sportelliSearchCallback(array &$form, FormStateInterface $form_state) {

    // Instantiate an AjaxResponse Object to return.
    $ajax_response = new AjaxResponse();
    $code = $form_state->getValue('comune');
    $code = explode('_', $code);
    $comune_id = $code[0];
    $provincia_id = $code[1];
    $utils = \Drupal::service('sportelli.utils');
    $sportelli = $utils->getSportelli($comune_id, $provincia_id);
    $ajax_response->addCommand(new HtmlCommand('#sportelli-list', $sportelli));
    return $ajax_response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
}

?>