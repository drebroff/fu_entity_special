<?php

/**
 * @file
 * Contains fu_content_entity.page.inc.
 *
 * Page callback for Funamy content entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Funamy content entity templates.
 *
 * Default template: fu_content_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_fu_content_entity(array &$variables) {
  // Fetch FuContentEntity Entity Object.
  $fu_content_entity = $variables['elements']['#fu_content_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
