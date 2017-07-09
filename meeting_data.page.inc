<?php

/**
 * @file
 * Contains meeting_data.page.inc.
 *
 * Page callback for Meeting data entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Meeting data templates.
 *
 * Default template: meeting_data.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_meeting_data(array &$variables) {
  // Fetch MeetingData Entity Object.
  $meeting_data = $variables['elements']['#meeting_data'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
