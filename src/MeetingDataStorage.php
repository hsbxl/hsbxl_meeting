<?php

namespace Drupal\hsbxl_meeting;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\hsbxl_meeting\Entity\MeetingDataInterface;

/**
 * Defines the storage handler class for Meeting data entities.
 *
 * This extends the base storage class, adding required special handling for
 * Meeting data entities.
 *
 * @ingroup hsbxl_meeting
 */
class MeetingDataStorage extends SqlContentEntityStorage implements MeetingDataStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(MeetingDataInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {meeting_data_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {meeting_data_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(MeetingDataInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {meeting_data_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('meeting_data_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
