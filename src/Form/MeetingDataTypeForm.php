<?php

namespace Drupal\hsbxl_meeting\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MeetingDataTypeForm.
 */
class MeetingDataTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $meeting_data_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $meeting_data_type->label(),
      '#description' => $this->t("Label for the Meeting data type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $meeting_data_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\hsbxl_meeting\Entity\MeetingDataType::load',
      ],
      '#disabled' => !$meeting_data_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $meeting_data_type = $this->entity;
    $status = $meeting_data_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Meeting data type.', [
          '%label' => $meeting_data_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Meeting data type.', [
          '%label' => $meeting_data_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($meeting_data_type->toUrl('collection'));
  }

}
