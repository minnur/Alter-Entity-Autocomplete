<?php

namespace Drupal\alter_entity_autocomplete\Controller;

use Drupal\Core\KeyValueStore\KeyValueStoreInterface;
use Drupal\alter_entity_autocomplete\AlteredEntityAutocompleteMatcher;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\system\Controller\EntityAutocompleteController;

/**
 * Extends the autocomplete controller to add more info.
 */
class AlteredEntityAutocompleteController extends EntityAutocompleteController {

  /**
   * The autocomplete matcher for entity references.
   *
   * @var matcher
   */
  protected $matcher;

  /**
   * {@inheritdoc}
   */
  public function __construct(AlteredEntityAutocompleteMatcher $matcher, KeyValueStoreInterface $key_value) {
    $this->matcher = $matcher;
    $this->keyValue = $key_value;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('alter_entity_autocomplete.autocomplete_matcher'),
      $container->get('keyvalue')->get('entity_autocomplete')
    );
  }

}
