<?php

/**
 * @file
 * Hooks provided by the modulo_y module.
 */
/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alter the links of a comment.
 *
 * @param array &$content
 *   A renderable array of the page content to alter.
 *
 */
function hook_modulo_y_mi_hook(array &$content) {
  $content['wada'] = [
    '#markup' => 'faq',
  ];
}

/**
 * @} End of "addtogroup hooks".
 */
