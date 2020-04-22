<?php

namespace Drupal\fu_entity_special;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class FuContentEntityStorage extends SqlContentEntityStorage implements FuContentEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(FuContentEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {fu_content_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {fu_content_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(FuContentEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {fu_content_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('fu_content_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
