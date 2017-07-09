<?php

namespace Drupal\hsbxl_meeting\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Meeting data type entity.
 *
 * @ConfigEntityType(
 *   id = "meeting_data_type",
 *   label = @Translation("Meeting data type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\hsbxl_meeting\MeetingDataTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\hsbxl_meeting\Form\MeetingDataTypeForm",
 *       "edit" = "Drupal\hsbxl_meeting\Form\MeetingDataTypeForm",
 *       "delete" = "Drupal\hsbxl_meeting\Form\MeetingDataTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\hsbxl_meeting\MeetingDataTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "meeting_data_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "meeting_data",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "//meeting_data_type/{meeting_data_type}",
 *     "add-form" = "//meeting_data_type/add",
 *     "edit-form" = "//meeting_data_type/{meeting_data_type}/edit",
 *     "delete-form" = "//meeting_data_type/{meeting_data_type}/delete",
 *     "collection" = "//meeting_data_type"
 *   }
 * )
 */
class MeetingDataType extends ConfigEntityBundleBase implements MeetingDataTypeInterface {

  /**
   * The Meeting data type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Meeting data type label.
   *
   * @var string
   */
  protected $label;

}
