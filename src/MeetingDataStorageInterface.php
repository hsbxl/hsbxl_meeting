<?php

namespace Drupal\hsbxl_meeting;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface MeetingDataStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Meeting data revision IDs for a specific Meeting data.
   *
   * @param \Drupal\hsbxl_meeting\Entity\MeetingDataInterface $entity
   *   The Meeting data entity.
   *
   * @return int[]
   *   Meeting data revision IDs (in ascending order).
   */
  public function revisionIds(MeetingDataInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Meeting data author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Meeting data revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\hsbxl_meeting\Entity\MeetingDataInterface $entity
   *   The Meeting data entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MeetingDataInterface $entity);

  /**
   * Unsets the language for all Meeting data with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
