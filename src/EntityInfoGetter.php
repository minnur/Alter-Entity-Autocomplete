<?php

namespace Drupal\alter_entity_autocomplete;

use Drupal\Core\Entity\Entity;
use Drupal\Core\Utility\Token;
use Drupal\Core\Entity\EntityPublishedTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
   * The token service.
   *
   * @var Drupal\Core\Utility\Token
   */
  protected $tokenizer;

  /**
   * Constructs the EntityInfoGetter.
   *
   * @var \Drupal\Core\Utility\Token
   */
  public function __construct(Token $tokenizer) {
    $this->tokenizer = $tokenizer;
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
    $txt = "";
    if ($this->entity) {
      if ($this->entity->getEntityType()->id() == 'node') {
        $type = $this->tokenizer->replace("[node:type-name]", ["node" => $this->entity]);
        $title = $this->tokenizer->replace("[node:title]", ["node" => $this->entity]);
        $nid = $this->tokenizer->replace("[node:nid]", ["node" => $this->entity]);
        /* Removing parenthesis from title and type as Drupal take everything
        in parenthesis for ID.*/
        $type = str_replace(["(", ")"], "", $type);
        $title = str_replace(["(", ")"], "", $title);
        $txt = $title . " (" . $nid . ") [" . $type . "]";

      }
      else {
        // Removing parenthesis here too.
        $txt = str_replace(["(", ")"], "", $this->entity->label()) . " - (" . $this->entity->id() . ")";
      }
    }
    if ($this->entity instanceof EntityPublishedTrait) {
      $status = ($this->entity->isPublished()) ? "Published" : "Unpublished";
      $txt .= " [" . $status . "]";
    }
    return $txt;
  }

}
