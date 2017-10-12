<?php

namespace Drupal\alter_entity_autocomplete;

use Drupal\Core\Entity\Entity;

/**
 * Service to output info about nodes in Autocompleters.
 */
class EntityInfoGetter {

  /**
   * The entity we should get info from.
   *
   * @var Drupal\Core\Entity\Entity
   */
  protected $entity;
  /**
   * The string we use to return the info.
   *
   * @var string
   */
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
        $txt = $token_service->replace($this->infoToken, ['node' => $this->entity]);
      }
      else {
        $txt = $this->entity->label() . " - (" . $this->entity->id() . ")";
      }
    }
    $status = ($this->entity->isPublished()) ? "Published" : "Unpublished";
    $txt .= " [" . $status . "]";
    return $txt;
  }

}
