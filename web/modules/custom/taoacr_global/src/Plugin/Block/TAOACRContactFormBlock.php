<?php declare(strict_types = 1);

namespace Drupal\taoacr_global\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Plugin\migrate\destination\Entity;
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

  private readonly EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructs the plugin instance.
   */
  /*
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }
  /*

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    /*
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
    );
    */
    $new = new self($configuration, $plugin_id, $plugin_definition);
    $new->entityTypeManager = $container->get('entity_type.manager');

  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'example' => $this->t('Hello world!'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['example'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Example'),
      '#default_value' => $this->configuration['example'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['example'] = $form_state->getValue('example');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
