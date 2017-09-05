<?php

namespace Drupal\alter_entity_autocomplete;

use Drupal\Core\Entity\Entity;

/**
 * Service to output info about nodes in Autocompleters.
 */
class NodeInfoGetter {
  protected $node;
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
   * @param Drupal\Core\Entity\Entity $node
   *   The node to be used.
   */
  public function setNode(Entity $node) {
    $this->node = $node;
  }

  /**
   * Outputs info about the entity for autocompletes.
   *
   * @return string
   *   The info based on configuration.
   */
  public function getInfo() {
    $token_service = \Drupal::service('token');
    $txt = $token_service->replace("[node:title] - ([node:nid]) [[node:type]", ['node' => $this->node]);
    if ($this->node->getEntityType()->id() == 'node') {
      $status = ($this->node->isPublished()) ? " - Published" : " - Unpublished";
      $txt .= " " . $status . "]";
    }
    return $txt;
  }

}
