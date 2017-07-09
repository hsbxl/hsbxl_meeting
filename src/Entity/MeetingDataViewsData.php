<?php

namespace Drupal\hsbxl_meeting\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Meeting data entities.
 */
class MeetingDataViewsData extends EntityViewsData {

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
