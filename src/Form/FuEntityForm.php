<?php

namespace Drupal\fu_entity_special\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FuEntityForm.
 */
class FuEntityForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $fu_entity = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $fu_entity->label(),
      '#description' => $this->t("Label for the Funami entity."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $fu_entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\fu_entity_special\Entity\FuEntity::load',
      ],
      '#disabled' => !$fu_entity->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $fu_entity = $this->entity;
    $status = $fu_entity->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Funami entity.', [
          '%label' => $fu_entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Funami entity.', [
          '%label' => $fu_entity->label(),
        ]));
    }
    $form_state->setRedirectUrl($fu_entity->toUrl('collection'));
  }

}
