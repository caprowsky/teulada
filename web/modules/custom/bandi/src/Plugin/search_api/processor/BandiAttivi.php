<?php

namespace Drupal\bandi\Plugin\search_api\processor;

use Drupal\Core\Datetime\Element\Datetime;
use Drupal\search_api\Datasource\DatasourceInterface;
use Drupal\search_api\Item\ItemInterface;
use Drupal\search_api\Processor\ProcessorPluginBase;
use Drupal\search_api\Processor\ProcessorProperty;

/**
 * Adds the item's URL to the indexed data.
 *
 * @SearchApiProcessor(
 *   id = "bandiattivi",
 *   label = @Translation("Bandi attivi"),
 *   description = @Translation("Verifica se i bandi sono attivi o no"),
 *   stages = {
 *     "add_properties" = 0,
 *   },
 *   locked = true,
 *   hidden = false,
 * )
 */
class BandiAttivi extends ProcessorPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getPropertyDefinitions(DatasourceInterface $datasource = NULL) {
    $properties = [];

    if (!$datasource) {
      $definition = [
        'label' => $this->t('Bandi attivi'),
        'description' => $this->t('Il bando è scaduto o no?'),
        'type' => 'string',
        'processor_id' => $this->getPluginId(),
      ];
      $properties['search_api_bandiattivi'] = new ProcessorProperty($definition);
    }

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function addFieldValues(ItemInterface $item) {
    $entity = $item->getOriginalObject()->getValue();
    /* @var \Drupal\node\Entity\Node $entity */
    if ($entity->bundle() == 'bando') {
      $fields = $this->getFieldsHelper()
        ->filterForPropertyPath($item->getFields(), NULL, 'search_api_bandiattivi');
      foreach ($fields as $field) {
        if (!$field->getDatasourceId()) {
          $date_value = $entity->field_data_scadenza_agevolazione->getValue()[0]['value'];
          $format = 'Y-m-d\TH:i:s';
          $date = \Drupal\Core\Datetime\DrupalDateTime::createFromFormat($format, $date_value);
          $date_timestamp = $date->format('U');
          $now = time();
          $value = t('Attive');

          if ($now > $date_timestamp) {
            $value = t('Non attive');
          }
          $field->addValue($value);


        }
      }
    }
  }
}


