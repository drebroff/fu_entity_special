<?php

namespace Drupal\fu_entity_special;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\fu_entity_special\Entity\FuContentEntityInterface;

/**
 * Defines the storage handler class for Funamy content entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Funamy content entity entities.
 *
 * @ingroup fu_entity_special
 */
interface FuContentEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Funamy content entity revision IDs for a specific Funamy content entity.
   *
   * @param \Drupal\fu_entity_special\Entity\FuContentEntityInterface $entity
   *   The Funamy content entity entity.
   *
   * @return int[]
   *   Funamy content entity revision IDs (in ascending order).
   */
  public function revisionIds(FuContentEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Funamy content entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Funamy content entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\fu_entity_special\Entity\FuContentEntityInterface $entity
   *   The Funamy content entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(FuContentEntityInterface $entity);

  /**
   * Unsets the language for all Funamy content entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
