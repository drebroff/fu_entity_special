<?php

namespace Drupal\fu_entity_special\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\fu_entity_special\Entity\FuContentEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class FuContentEntityController.
 *
 *  Returns responses for Funamy content entity routes.
 */
class FuContentEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Funamy content entity revision.
   *
   * @param int $fu_content_entity_revision
   *   The Funamy content entity revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($fu_content_entity_revision) {
    $fu_content_entity = $this->entityTypeManager()->getStorage('fu_content_entity')
      ->loadRevision($fu_content_entity_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('fu_content_entity');

    return $view_builder->view($fu_content_entity);
  }

  /**
   * Page title callback for a Funamy content entity revision.
   *
   * @param int $fu_content_entity_revision
   *   The Funamy content entity revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($fu_content_entity_revision) {
    $fu_content_entity = $this->entityTypeManager()->getStorage('fu_content_entity')
      ->loadRevision($fu_content_entity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $fu_content_entity->label(),
      '%date' => $this->dateFormatter->format($fu_content_entity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Funamy content entity.
   *
   * @param \Drupal\fu_entity_special\Entity\FuContentEntityInterface $fu_content_entity
   *   A Funamy content entity object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(FuContentEntityInterface $fu_content_entity) {
    $account = $this->currentUser();
    $fu_content_entity_storage = $this->entityTypeManager()->getStorage('fu_content_entity');

    $langcode = $fu_content_entity->language()->getId();
    $langname = $fu_content_entity->language()->getName();
    $languages = $fu_content_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $fu_content_entity->label()]) : $this->t('Revisions for %title', ['%title' => $fu_content_entity->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all funamy content entity revisions") || $account->hasPermission('administer funamy content entity entities')));
    $delete_permission = (($account->hasPermission("delete all funamy content entity revisions") || $account->hasPermission('administer funamy content entity entities')));

    $rows = [];

    $vids = $fu_content_entity_storage->revisionIds($fu_content_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\fu_entity_special\FuContentEntityInterface $revision */
      $revision = $fu_content_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $fu_content_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.fu_content_entity.revision', [
            'fu_content_entity' => $fu_content_entity->id(),
            'fu_content_entity_revision' => $vid,
          ]));
        }
        else {
          $link = $fu_content_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
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
              Url::fromRoute('entity.fu_content_entity.translation_revert', [
                'fu_content_entity' => $fu_content_entity->id(),
                'fu_content_entity_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.fu_content_entity.revision_revert', [
                'fu_content_entity' => $fu_content_entity->id(),
                'fu_content_entity_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.fu_content_entity.revision_delete', [
                'fu_content_entity' => $fu_content_entity->id(),
                'fu_content_entity_revision' => $vid,
              ]),
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

    $build['fu_content_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
