<?php

namespace Drupal\alter_entity_autocomplete\Plugin\Field\FieldWidget;


use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\Plugin\Field\FieldWidget\EntityReferenceAutocompleteWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * A widget that adds more info about referenced and linked entities.
 *
 * @FieldWidget(
 *   id = "entity_autocomplete_configurable",
 *   label = @Translation("Configurable Entity Autocomplete"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityAutocompleteConfigurableWidget extends EntityReferenceAutocompleteWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    /*
     * Using the FormElement defined in
     * \Drupal\altered_entity_autocomplete\Element\EntityAutocompleteConfigurable
     */
    $element['target_id']['#type'] = "entity_autocomplete_configurable";
    return $element;
  }

}
