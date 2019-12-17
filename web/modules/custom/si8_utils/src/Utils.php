<?php

namespace Drupal\si8_utils;

class Utils {

  public function getViewWithArgument($views_name, $display_id, $args = []) {
    $view = \Drupal\views\Views::getView($views_name);

    if (!is_array($args)) {
      $args = [$args];
    }

    if (is_object($view)) {
      $view->setArguments($args);
      $view->setDisplay($display_id);
      $view->preExecute();
      $view->execute();
      return $view->buildRenderable($display_id, $args);
    } else {
      return FALSE;
    }
  }

  /**
   * Check if a term has a parent
   * @param $tid
   *
   * @return bool
   */
  public function checkTermParent($tid) {
    $term = \Drupal\taxonomy\Entity\Term::load($tid);
    $storage = \Drupal::service('entity_type.manager')
      ->getStorage('taxonomy_term');
    $parents = $storage->loadParents($term->id());
    if (!empty($parents)) {
      return TRUE;
    }
    return FALSE;
  }
}