<?php declare(strict_types = 1);

namespace Drupal\taoacr_global\EventSubscriber;

use Drupal\modulo_y\Event\PageContentAlterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @todo Add description for this subscriber.
 */
final class ModuloYEventSubscriber implements EventSubscriberInterface {

  /**
   * Kernel request event handler.
   */
  public function onKernelRequest(RequestEvent $event): void {
    // @todo Place your code here.
  }

  /**
   * Kernel response event handler.
   */
  public function onKernelResponse(ResponseEvent $event): void {
    // @todo Place your code here.
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      PageContentAlterEvent::PAGE_ALTER_EVENT => ['alterPageContent'],
    ];
  }

  public static function alterPageContent(PageContentAlterEvent $event) {
    $event->content['another'] = [
      '#type' => 'item',
      '#markup' => 'I did it',
      ];
  }

}
