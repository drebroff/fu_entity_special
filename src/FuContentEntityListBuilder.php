<?php

namespace Drupal\fu_entity_special;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Funamy content entity entities.
 *
 * @ingroup fu_entity_special
 */
class FuContentEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Funamy content entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\fu_entity_special\Entity\FuContentEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.fu_content_entity.edit_form',
      ['fu_content_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
