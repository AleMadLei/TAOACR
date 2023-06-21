<?php

namespace Drupal\modulo_y\Event;

use Drupal\Component\EventDispatcher\Event;

/**
 * Event that is fired when a user logs in.
 */
class PageContentAlterEvent extends Event {

  // This makes it easier for subscribers to reliably use our event name.
  const PAGE_ALTER_EVENT = 'modulo_y.page_alter';

  /**
   * Constructs the object.
   */
  public function __construct(public array $content) {
  }

}
