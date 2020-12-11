<?php

namespace Drupal\bgg_search\Controller;

use Drupal\bgg_search\BggApi;
use Drupal\bgg_search\DataBaseService;
use Drupal\bgg_search\DataCleaning;
use Drupal\Core\Controller\ControllerBase;
use Laminas\Diactoros\Response\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Board game search
 * @return array
 * Board game in a render array
 */
class BggSearchController extends ControllerBase {

  /**
   * Board game geek (bgg) api service
   *
   * @var \Drupal\bgg_search\BggApi
   */
  protected $bggApi;

  /**
   * Service that handles talking to database
   *
   * @var \Drupal\bgg_search\DataBaseService
   */
  protected $DataBaseService;

  /**
   * Service that cleans the data and makes sure that
   * other classes are working with the same data.
   *
   * @var \Drupal\bgg_search\DataCleaning
   */
  protected $DataCleaning;

  /**
   * BggSearchController constructor.
   *
   * @param BggApi $BggApi
   * @param DataBaseService $DataBaseService
   * @param DataCleaning $DataCleaning
   */
  public function __construct( BggApi $BggApi, DataBaseService $DataBaseService, DataCleaning $DataCleaning ) {
    $this->bggApi = $BggApi;
    $this->DataBaseService = $DataBaseService;
    $this->DataCleaning = $DataCleaning;
  }

  /**
   * {@inheritDoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('bgg_search.BggApi'),
      $container->get('bgg_search.DataBaseService'),
      $container->get('bgg_search.DataCleaning')
    );
  }

  /**
   * Finds boardgames from a parameters q and returns
   * simple json array with names of boardgames
   *
   * @return JsonResponse
   */
  public function autocomplete() {
    $partialSearchTerm = \Drupal::request()->query->get('q');
    $response = $this->bggApi->SearchForBgg($partialSearchTerm);

    $result = [];
    for ($i = 0; $i <= 10; $i++) {
      array_push($result,$response['boardgame'][$i]['name']);
    }

    return new JsonResponse($result);
  }
}
