<?php

namespace Drupal\si8_utils\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'ElencoArgomenti' block.
 *
 * @Block(
 *  id = "elenco_argomenti",
 *  admin_label = @Translation("Elenco Argomenti"),
 * )
 */
class ElencoArgomenti extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $facets = [];

    $facets[] = [
      'value' => [
        '#type' => 'link',
        '#url' => Url::fromUri('internal:/news'),
        '#title' => t('All news'),
      ],
    ];

    $container = \Drupal::getContainer();
    $terms = $container->get('entity.manager')
      ->getStorage('taxonomy_term')
      ->loadTree('argomenti');
    if (!empty($terms)) {
      foreach ($terms as $term) {
        $curr_langcode = \Drupal::languageManager()
          ->getCurrentLanguage(\Drupal\Core\Language\LanguageInterface::TYPE_CONTENT)
          ->getId();
        // retrieve term
        $taxonomy_term = \Drupal\taxonomy\Entity\Term::load($term->tid);
        // retrieve the translated taxonomy term in specified language ($curr_langcode) with fallback to default language if translation not exists

        $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $taxonomy_term_trans = \Drupal::service('entity.repository')
          ->getTranslationFromContext($taxonomy_term, $curr_langcode);
        $name = $taxonomy_term_trans->label();
        // get the value of the field "myfield"
        // $myfield_translated = $taxonomy_term_trans->myfield->value;

        $trans = \Drupal::transliteration();
        $transformed = strtolower($trans->transliterate($name, $langcode));

        $facets[] = [
          'value' => [
            '#type' => 'link',
            '#url' => Url::fromUri('internal:/news/' . $term->tid . '/' . str_replace(' ', '-', $transformed), ['set_active_class' => TRUE]),
            '#title' => $name,
          ],
        ];
      }
    }

    $render_array = [
      '#theme' => 'item_list',
      '#title' => t('Arguments'),
      '#items' => $facets,
    ];

    $build['elenco_argomenti']['#markup'] = render($render_array);

    return $build;
  }
}
