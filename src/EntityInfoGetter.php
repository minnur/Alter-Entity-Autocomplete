<?php

namespace Drupal\alter_entity_autocomplete;

use Drupal\Core\Entity\Entity;

/**
 * Service to output info about nodes in Autocompleters.
 */
class EntityInfoGetter {

  /**
   * @var Entity
   */
  protected $entity;
  protected $infoToken;

  /**
   * Creates a NodeInfoGetter service.
   */
  public function __construct() {
    $this->infoToken = "[node:title] ([node:nid]) [[node:type]]";
  }

  /**
   * Sets the node for this object.
   *
   * @param \Drupal\Core\Entity\Entity $entity
   *   The node to be used.
   */
  public function setEntity(Entity $entity) {
    $this->entity = $entity;
  }

  /**
   * Outputs info about the entity for autocompletes.
   *
   * @return string
   *   The info based on configuration.
   */
  public function getInfo() {
    $token_service = \Drupal::service('token');
    $txt = "";
    if ($this->entity) {
      if ($this->entity->getEntityType()->id() == 'node') {
        $txt = $token_service->replace("[node:title] - ([node:nid]) [[node:type-name]", ['node' => $this->entity]);
        $status = ($this->entity->isPublished()) ? " - Published" : " - Unpublished";
        $txt .= " " . $status . "]";
      }
      else {
        $txt = $this->entity->label() . " - (" . $this->entity->id() . ")";
      }
    }
    return $txt;
  }

}
