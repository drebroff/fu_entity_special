<?php

namespace Drupal\fu_entity_special\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Funamy content entity entities.
 *
 * @ingroup fu_entity_special
 */
interface FuContentEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Funamy content entity name.
   *
   * @return string
   *   Name of the Funamy content entity.
   */
  public function getName();

  /**
   * Sets the Funamy content entity name.
   *
   * @param string $name
   *   The Funamy content entity name.
   *
   * @return \Drupal\fu_entity_special\Entity\FuContentEntityInterface
   *   The called Funamy content entity entity.
   */
  public function setName($name);

  /**
   * Gets the Funamy content entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Funamy content entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Funamy content entity creation timestamp.
   *
   * @param int $timestamp
   *   The Funamy content entity creation timestamp.
   *
   * @return \Drupal\fu_entity_special\Entity\FuContentEntityInterface
   *   The called Funamy content entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Funamy content entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Funamy content entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\fu_entity_special\Entity\FuContentEntityInterface
   *   The called Funamy content entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Funamy content entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Funamy content entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\fu_entity_special\Entity\FuContentEntityInterface
   *   The called Funamy content entity entity.
   */
  public function setRevisionUserId($uid);

}
