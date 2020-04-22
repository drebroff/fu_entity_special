<?php

namespace Drupal\fu_entity_special\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Funamy content entity type entity.
 *
 * @ConfigEntityType(
 *   id = "fu_content_entity_type",
 *   label = @Translation("Funamy content entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\fu_entity_special\FuContentEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\fu_entity_special\Form\FuContentEntityTypeForm",
 *       "edit" = "Drupal\fu_entity_special\Form\FuContentEntityTypeForm",
 *       "delete" = "Drupal\fu_entity_special\Form\FuContentEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\fu_entity_special\FuContentEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "fu_content_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "fu_content_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/fu_content_entity_type/{fu_content_entity_type}",
 *     "add-form" = "/admin/structure/fu_content_entity_type/add",
 *     "edit-form" = "/admin/structure/fu_content_entity_type/{fu_content_entity_type}/edit",
 *     "delete-form" = "/admin/structure/fu_content_entity_type/{fu_content_entity_type}/delete",
 *     "collection" = "/admin/structure/fu_content_entity_type"
 *   }
 * )
 */
class FuContentEntityType extends ConfigEntityBundleBase implements FuContentEntityTypeInterface {

  /**
   * The Funamy content entity type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Funamy content entity type label.
   *
   * @var string
   */
  protected $label;

}
