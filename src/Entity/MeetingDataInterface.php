<?php

namespace Drupal\hsbxl_meeting\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Meeting data entities.
 *
 * @ingroup hsbxl_meeting
 */
interface MeetingDataInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Meeting data name.
   *
   * @return string
   *   Name of the Meeting data.
   */
  public function getName();

  /**
   * Sets the Meeting data name.
   *
   * @param string $name
   *   The Meeting data name.
   *
   * @return \Drupal\hsbxl_meeting\Entity\MeetingDataInterface
   *   The called Meeting data entity.
   */
  public function setName($name);

  /**
   * Gets the Meeting data creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Meeting data.
   */
  public function getCreatedTime();

  /**
   * Sets the Meeting data creation timestamp.
   *
   * @param int $timestamp
   *   The Meeting data creation timestamp.
   *
   * @return \Drupal\hsbxl_meeting\Entity\MeetingDataInterface
   *   The called Meeting data entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Meeting data published status indicator.
   *
   * Unpublished Meeting data are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Meeting data is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Meeting data.
   *
   * @param bool $published
   *   TRUE to set this Meeting data to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\hsbxl_meeting\Entity\MeetingDataInterface
   *   The called Meeting data entity.
   */
  public function setPublished($published);

  /**
   * Gets the Meeting data revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Meeting data revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\hsbxl_meeting\Entity\MeetingDataInterface
   *   The called Meeting data entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Meeting data revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Meeting data revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\hsbxl_meeting\Entity\MeetingDataInterface
   *   The called Meeting data entity.
   */
  public function setRevisionUserId($uid);

}
