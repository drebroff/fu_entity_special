<?php

namespace Drupal\fu_entity_special\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Funamy content entity entities.
 */
class FuContentEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
