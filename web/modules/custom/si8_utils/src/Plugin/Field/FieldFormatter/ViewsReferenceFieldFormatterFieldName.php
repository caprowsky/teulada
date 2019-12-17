<?php

namespace Drupal\si8_utils\Plugin\Field\FieldFormatter;

use Drupal\views\Views;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Field formatter for Viewsreference Field - View name.
 *
 * @FieldFormatter(
 *   id = "viewsreference_formatter_fieldname",
 *   label = @Translation("Views Reference View Name"),
 *   field_types = {"viewsreference"}
 * )
 */
class ViewsReferenceFieldFormatterFieldName extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    $options = parent::defaultSettings();
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $view_name = $item->getValue()['target_id'];
      $view = Views::getView($view_name);
      // Someone may have deleted the View.
      if (!is_object($view)) {
        continue;
      }

      $display_id = $item->getValue()['display_id'];
      $view->setDisplay($display_id);
      $display = $view->getDisplay($view->current_display);

      $title_render_array = array(
        '#theme' => 'viewsreference__view_title',
        '#title' => $display->display['display_title'],
      );

      $elements[$delta]['title'] = $title_render_array;

    }

    return $elements;
  }


}