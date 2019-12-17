<?php

namespace Drupal\si8_utils;

/**
 * Class DefaultService.
 *
 * @package Drupal\si8_utils
 */
class DrupalViewArgument extends \Twig_Extension {

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'drupal_view_argument';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('drupal_view_argument',
        [$this, 'drupal_view_argument'],
        [
          'is_safe' => ['html'],
        ]),
    ];
  }

  /**
   * The php function to load a view with custom arguments
   */
  public function drupal_view_argument($views_name, $display_id, $args = []) {
    return \Drupal::service('si8_utils.utils')->getViewWithArgument($views_name, $display_id, $args);
  }

}