<?php

namespace Drupal\alter_entity_autocomplete\Plugin\Field\FieldWidget;

use Drupal\link\Plugin\Field\FieldWidget\LinkWidget;
use Drupal\alter_entity_autocomplete\Element\EntityAutocompleteConfigurable;

/**
 * Extends LinkWidget allowing us to display more info for links.
 *
 * @FieldWidget(
 *   id = "entity_autocomplete_link",
 *   label = @Translation("Entity Autocomplete Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class EntityAutocompleteLink extends LinkWidget {

  /**
   * {@inheritdoc}
   */
  protected static function getUriAsDisplayableString($uri) {
    $scheme = parse_url($uri, PHP_URL_SCHEME);
    $displayable_string = $uri;
    if ($scheme === 'entity') {
      /* Copied from the Core's link module, but using our
       * Drupal\alter_entity_autocomplete\Element\EntityAutocompleteConfigurable
       * class to output more info about node entities.
       */
      list($entity_type, $entity_id) = explode('/', substr($uri, 7), 2);
      if ($entity_type == 'node' && $entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load($entity_id)) {
        $displayable_string = EntityAutocompleteConfigurable::getEntityLabels([$entity]);
      }
    }
    else {
      $displayable_string = parent::getUriAsDisplayableString($uri);
    }
    return $displayable_string;
  }

}
