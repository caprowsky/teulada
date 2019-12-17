<?php
/**
 * @file
 * Contains \Drupal\si8_utils\Form\Admin.
 */

namespace Drupal\si8_utils\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\UrlHelper;
/**
 * Contribute form.
 */
class Admin extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'si8_utils_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $languages = \Drupal::languageManager()->getLanguages();

    foreach ($languages as $language) {
      $form['valuta_link_' . $language->getId()] = [
        '#type' => 'textfield',
        '#title' => 'Valuta sito ' . $language->getName(),
        '#description' => 'Inserisci l\'url assoluto (compreso di http) del form per la valutazione del sito.',
        '#default_value' => \Drupal::state()->get('si8_utils.valuta_link_' . $language->getId()),
      ];
    }

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
    $values = $form_state->getValues();

    foreach ($values as $key => $value) {
      if (substr($key, 0, 6) == 'valuta') {
        $url = $form_state->getValue($key);
        if (!UrlHelper::isValid($url, $absolute = TRUE)) {
          $form_state->setErrorByName($key, $this->t("L'indirizzo '%url' is invalid, deve essere assoluto.", array('%url' => $form_state->getValue($key))));
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    foreach ($values as $key => $value) {
      if (substr($key, 0, 6) == 'valuta') {
        $url = $form_state->getValue($key);
        \Drupal::state()->set('si8_utils.' . $key, $url);
      }
    }

    drupal_set_message('Le configurazioni sono state salvate');

  }
}

?>