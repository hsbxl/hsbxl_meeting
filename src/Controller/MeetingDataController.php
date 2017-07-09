<?php

namespace Drupal\hsbxl_meeting\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\hsbxl_meeting\Entity\MeetingDataInterface;

/**
 * Class MeetingDataController.
 *
 *  Returns responses for Meeting data routes.
 */
class MeetingDataController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Meeting data  revision.
   *
   * @param int $meeting_data_revision
   *   The Meeting data  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($meeting_data_revision) {
    $meeting_data = $this->entityManager()->getStorage('meeting_data')->loadRevision($meeting_data_revision);
    $view_builder = $this->entityManager()->getViewBuilder('meeting_data');

    return $view_builder->view($meeting_data);
  }

  /**
   * Page title callback for a Meeting data  revision.
   *
   * @param int $meeting_data_revision
   *   The Meeting data  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($meeting_data_revision) {
    $meeting_data = $this->entityManager()->getStorage('meeting_data')->loadRevision($meeting_data_revision);
    return $this->t('Revision of %title from %date', ['%title' => $meeting_data->label(), '%date' => format_date($meeting_data->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Meeting data .
   *
   * @param \Drupal\hsbxl_meeting\Entity\MeetingDataInterface $meeting_data
   *   A Meeting data  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MeetingDataInterface $meeting_data) {
    $account = $this->currentUser();
    $langcode = $meeting_data->language()->getId();
    $langname = $meeting_data->language()->getName();
    $languages = $meeting_data->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $meeting_data_storage = $this->entityManager()->getStorage('meeting_data');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $meeting_data->label()]) : $this->t('Revisions for %title', ['%title' => $meeting_data->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all meeting data revisions") || $account->hasPermission('administer meeting data entities')));
    $delete_permission = (($account->hasPermission("delete all meeting data revisions") || $account->hasPermission('administer meeting data entities')));

    $rows = [];

    $vids = $meeting_data_storage->revisionIds($meeting_data);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\hsbxl_meeting\MeetingDataInterface $revision */
      $revision = $meeting_data_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $meeting_data->getRevisionId()) {
          $link = $this->l($date, new Url('entity.meeting_data.revision', ['meeting_data' => $meeting_data->id(), 'meeting_data_revision' => $vid]));
        }
        else {
          $link = $meeting_data->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.meeting_data.translation_revert', ['meeting_data' => $meeting_data->id(), 'meeting_data_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.meeting_data.revision_revert', ['meeting_data' => $meeting_data->id(), 'meeting_data_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.meeting_data.revision_delete', ['meeting_data' => $meeting_data->id(), 'meeting_data_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['meeting_data_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
