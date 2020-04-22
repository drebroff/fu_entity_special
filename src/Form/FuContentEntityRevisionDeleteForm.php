<?php

namespace Drupal\fu_entity_special\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Funamy content entity revision.
 *
 * @ingroup fu_entity_special
 */
class FuContentEntityRevisionDeleteForm extends ConfirmFormBase {

  /**
   * The Funamy content entity revision.
   *
   * @var \Drupal\fu_entity_special\Entity\FuContentEntityInterface
   */
  protected $revision;

  /**
   * The Funamy content entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $fuContentEntityStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->fuContentEntityStorage = $container->get('entity_type.manager')->getStorage('fu_content_entity');
    $instance->connection = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'fu_content_entity_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the revision from %revision-date?', [
      '%revision-date' => format_date($this->revision->getRevisionCreationTime()),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.fu_content_entity.version_history', ['fu_content_entity' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $fu_content_entity_revision = NULL) {
    $this->revision = $this->FuContentEntityStorage->loadRevision($fu_content_entity_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->FuContentEntityStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Funamy content entity: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addMessage(t('Revision from %revision-date of Funamy content entity %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.fu_content_entity.canonical',
       ['fu_content_entity' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {fu_content_entity_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.fu_content_entity.version_history',
         ['fu_content_entity' => $this->revision->id()]
      );
    }
  }

}
