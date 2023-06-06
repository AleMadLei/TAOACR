<?php

namespace Drupal\taoacr_global\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\taxonomy\Plugin\views\argument\Taxonomy;
use Drupal\taxonomy\TermInterface;
use Drupal\Tests\taxonomy\Functional\TaxonomyTermIndentationTest;
use Drupal\views\Views;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Returns responses for TAOACR Global routes.
 */
class WorkSamplesController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(TermInterface $term) {
    if ($term->bundle() !== 'work_type') {
      throw new NotFoundHttpException();
    }

      /** @var \Drupal\views\Views $view */
    $rendered = views_embed_view('work_samples', 'embed_filtered_by_work_type', $term->id());
    $output = [
      'title' => [
        '#markup' => $term->label(),
        '#prefix' => '<h2>',
        '#suffix' => '</h2>',
      ],
      'result' => $rendered,
    ];
    $output = \Drupal::service('renderer')->render($output);
    return new JsonResponse($output);

    /*

      /** @var \Drupal\views\Views $view */ /*
    $view = Views::getView('work_samples');
    $view->setDisplay('block_test');
    $view->setArguments([$term->id()]);
    $rendered = $view->render();

    $output = [
      'title' => [
        '#markup' => $term->label(),
        '#prefix' => '<h2>',
        '#suffix' => '</h2>',
      ],
      'result' => $rendered,
    ];
    $output = \Drupal::service('renderer')->render($output);
    return new JsonResponse($output);

    */
  }
}
