<?php

namespace Drupal\fu_entity_special\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FuContentEntityTypeForm.
 */
class FuContentEntityTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $fu_content_entity_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $fu_content_entity_type->label(),
      '#description' => $this->t("Label for the Funamy content entity type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $fu_content_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\fu_entity_special\Entity\FuContentEntityType::load',
      ],
      '#disabled' => !$fu_content_entity_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $fu_content_entity_type = $this->entity;
    $status = $fu_content_entity_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Funamy content entity type.', [
          '%label' => $fu_content_entity_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Funamy content entity type.', [
          '%label' => $fu_content_entity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($fu_content_entity_type->toUrl('collection'));
  }

}
