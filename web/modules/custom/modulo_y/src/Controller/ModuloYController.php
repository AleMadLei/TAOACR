<?php declare(strict_types = 1);

namespace Drupal\modulo_y\Controller;

use Drupal\modulo_y\Event\PageContentAlterEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\EventDispatcher\ContainerAwareEventDispatcher;

/**
 * Returns responses for Modulo Y routes.
 */
final class ModuloYController extends ControllerBase {


  public function __construct(protected ContainerAwareEventDispatcher $eventDispatcher) {
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('event_dispatcher')
    );
  }

  /**
   * Builds the response.
   */
  public function __invoke(): array {


    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    $this->moduleHandler()->invokeAll('modulo_y_mi_hook', [&$build]);
    $event = new PageContentAlterEvent($build);
    $this->eventDispatcher->dispatch($event, PageContentAlterEvent::PAGE_ALTER_EVENT);

    return $build;
  }

}
