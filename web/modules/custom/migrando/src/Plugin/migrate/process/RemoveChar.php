<?php

/**
 * @file
 * Contains \Drupal\migrando\Plugin\migrate\process\Removechar.
 */
namespace Drupal\migrando\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Process latitude and longitude and return the value for the D8 geofield.
 *
 * @MigrateProcessPlugin(
 *   id = "remove_char"
 * )
 */
class RemoveChar extends ProcessPluginBase {
  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $return = substr($value, 3);

    // Check for node/XXX paths
    $check = explode('/', $return);
    if ($check[1] == 'node') {
      $return = '';
    }

    return $return;
  }
}
