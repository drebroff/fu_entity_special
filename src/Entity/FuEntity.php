<?php

namespace Drupal\fu_entity_special\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Funami entity entity.
 *
 * @ConfigEntityType(
 *   id = "fu_entity",
 *   label = @Translation("Funami entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\fu_entity_special\FuEntityListBuilder",
 *     "form" = {
 *       "add" = "Drupal\fu_entity_special\Form\FuEntityForm",
 *       "edit" = "Drupal\fu_entity_special\Form\FuEntityForm",
 *       "delete" = "Drupal\fu_entity_special\Form\FuEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\fu_entity_special\FuEntityHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "fu_entity",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/fu_entity/{fu_entity}",
 *     "add-form" = "/admin/structure/fu_entity/add",
 *     "edit-form" = "/admin/structure/fu_entity/{fu_entity}/edit",
 *     "delete-form" = "/admin/structure/fu_entity/{fu_entity}/delete",
 *     "collection" = "/admin/structure/fu_entity"
 *   }
 * )
 */
class FuEntity extends ConfigEntityBase implements FuEntityInterface {

  /**
   * The Funami entity ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Funami entity label.
   *
   * @var string
   */
  protected $label;

}
