<?php

/**
 * @file
 * Contains Drupal\so8_utils\BreadcrumbBuilder.
 */

namespace Drupal\si8_utils;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Class BreadcrumbBuilder.
 *
 * @package Drupal\si8_utils
 */
class BreadcrumbBuilder implements BreadcrumbBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
    return $this->check_path($route_match);
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addCacheContexts(['route']);

    $route_object = $route_match->getRouteObject();

    $route_node = \Drupal::service('current_route_match');
    $node = $route_match->getParameter('node');

    $links = [];
    $links[] = Link::createFromRoute(t('Home'), '<front>');

    // Breadcrumb custom argomenti notizie
    if ($route_object->getPath() == '/news/{arg_0}/{arg_1}') {
      $links[] = Link::createFromRoute(t('News'), 'view.news.news');
    }

    // video
    if (!empty($node) && $node->bundle() == 'video') {
      $links[] = Link::fromTextAndUrl(t('Video'), Url::fromUri('internal:/video'));
    }
  
    // Breadcrumb custom archivio agevolazioni
    if ($route_object->getPath() == '/agevolazioni/archivio') {
      $links[] = Link::fromTextAndUrl(t('Support for businesses'), Url::fromUri('internal:/agevolazioni'));
    }
    
    

    // in evidenza
    if (!empty($node) && (!empty($node->field_tags))) {
      foreach ($node->get('field_tags')->referencedEntities() as $tag) {
        /**
         * casi aziendali 406
         * infografiche 408
         * speciali 407
         */
        $tids = ['406', '407', '408'];
        if (in_array($tag->id(), $tids)) {
          switch ($tag->id()) {
            case '406':
              $links[] = Link::fromTextAndUrl(t('Casi aziendali'), Url::fromUri('internal:/casi-aziendali'));
              break;

            case '407':
              $links[] = Link::fromTextAndUrl(t('Speciali'), Url::fromUri('internal:/infografiche'));
              break;

            case '408':
              $links[] = Link::fromTextAndUrl(t('Infografiche'), Url::fromUri('internal:/infografiche'));
              break;
          }
        }
      }
    }

    // Breadcrumb generico quando secondo elemento è "node"

    // Breadcrumb custom sportello unico
    /*$suape_paths = ['/sportello-unico/dove-si-trova', '/sportello-unico/trova-procedimento', '/sportello-unico/'];
    if (in_array($route_object->getPath(), $suape_paths)) {
      $url = Url::fromUri('internal:/sportello-unico');
      $links[] = Link::createFromRoute(t('Home'), '<front>');
      $links[] = Link::fromTextAndUrl(t('Suape'), $url);
    }*/

    $breadcrumb->setLinks($links);

    return $breadcrumb;
  }

  /**
   * @param RouteMatchInterface $route_match
   *
   * @return bool
   */
  private function check_path($route_match) {
    $route_object = $route_match->getRouteObject();
    $paths = ['/news/{arg_0}/{arg_1}', '/agevolazioni', '/agevolazioni/archivio'];


    $current_path = explode('/', \Drupal::request()->getRequestUri());
    if (isset($current_path[2]) && $current_path[2] == 'node') {
      return TRUE;
    }

    if (in_array($route_object->getPath(), $paths)) {
      return TRUE;
    }

    $route_node = \Drupal::service('current_route_match');
    $node = $route_match->getParameter('node');
    if (!empty($node) && (!empty($node->field_tags))) {
      foreach ($node->get('field_tags')->referencedEntities() as $tag) {
        /**
         * casi aziendali 406
         * infografiche 408
         * speciali 407
         */
        $tids = ['406', '407', '408'];
        if (in_array($tag->id(), $tids)) {
          return TRUE;
        }
      }
    }

    if (!empty($node) && $node->bundle() == 'video') {
      return TRUE;
    }

    return FALSE;
  }


}
