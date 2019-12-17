<?php
/**
 * Created by PhpStorm.
 * User: breidert
 * Date: 19.06.17
 * Time: 14:26
 */

namespace Drupal\rest_menu_items\Plugin\rest\resource;

use Drupal\Core\Cache\CacheableDependencyInterface;

class RestMenuItemsCachableDepenency implements CacheableDependencyInterface {

  // Minimum depth parameter
  protected $minDepth = 1;

  // Maximum depth parameter
  protected $maxDepth = 1;

  /**
   * RestMenuItemsCachableDepenency constructor.
   *
   * @param int $minDepth The minimum depth to be used as a cache context
   * @param int $maxDepth The maximum depth to be used as a cache context
   */
  public function __construct($minDepth, $maxDepth) {
    $this->minDepth = $minDepth;
    $this->maxDepth = $maxDepth;
  }


  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    $contexts = [];
    // URL parameters as contexts
    if($this->minDepth != 1 || $this->maxDepth != 1) {
      $contexts[] = 'url.query_args';
    }
    return $contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $tags = [];
    return $tags;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    // Default to 1 hour
    return 3600;
  }

}
