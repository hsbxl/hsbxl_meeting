<?php

namespace Drupal\hsbxl_meeting;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Meeting data entity.
 *
 * @see \Drupal\hsbxl_meeting\Entity\MeetingData.
 */
class MeetingDataAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\hsbxl_meeting\Entity\MeetingDataInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished meeting data entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published meeting data entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit meeting data entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete meeting data entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add meeting data entities');
  }

}
