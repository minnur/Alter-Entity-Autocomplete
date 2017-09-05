<?php

namespace Drupal\alter_entity_autocomplete\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Extending RouteSubscriberBase to inject more info on nodes for autocomplete.
 */
class AutocompleteRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('system.entity_autocomplete')) {
      $route->setDefault('_controller', '\Drupal\alter_entity_autocomplete\Controller\AlteredEntityAutocompleteController::handleAutocomplete');
    }
  }

}
