<?php

namespace Drupal\hsbxl_meeting;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Meeting data entities.
 *
 * @ingroup hsbxl_meeting
 */
class MeetingDataListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Meeting data ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\hsbxl_meeting\Entity\MeetingData */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.meeting_data.edit_form',
      ['meeting_data' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
