<?php declare(strict_types = 1);

namespace Drupal\taoacr_global\Plugin\Block;

use Drupal\contact\ContactFormInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Logger\LoggerChannel;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a contact form block.
 *
 * @Block(
 *   id = "taoacr_global_contact_form",
 *   admin_label = @Translation("Contact Form"),
 *   category = @Translation("TAOACR"),
 * )
 */
final class TAOACRContactFormBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityFormBuilderInterface $entityFormBuilder,
    private readonly LoggerChannel $logger,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('entity.form_builder'),
      $container->get('logger.factory')->get('taoacr_global')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'contact_form' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $forms = $this
      ->entityTypeManager
      ->getStorage('contact_form')
      ->loadMultiple();

    $form['contact_form'] = [
      '#empty_option' => $this->t('- Select a Contact Form -'),
      '#default_value' => $this->configuration['contact_form'],
      '#options' => array_map(fn (ContactFormInterface $a) => $a->label(), $forms),
      '#required' => TRUE,
      '#title' => $this->t('Contact form'),
      '#type' => 'select',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['contact_form'] = $form_state->getValue('contact_form');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $form = $this
      ->entityTypeManager
      ->getStorage('contact_form')
      ->load($this->configuration['contact_form']);

    if (empty($form)) {
      $this->logger->error('Form "@form" is not available.', ['@form' => $this->configuration['contact_form']]);
      $this->messenger()->addError($this->t('Form "@form" is not available.', ['@form' => $this->configuration['contact_form']]));
      return [];
    }

    $contact_message = $this->entityTypeManager
      ->getStorage('contact_message')
      ->create(['contact_form' => $form->id()]);

    $build['content'] = [
      'contact_form' => $this->entityFormBuilder->getForm($contact_message),
    ];
    return $build;
  }

}
