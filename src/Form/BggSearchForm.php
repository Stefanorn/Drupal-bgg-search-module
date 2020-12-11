<?php

namespace Drupal\bgg_search\Form;

use Drupal\bgg_search\BggApi;
use Drupal\bgg_search\DataBaseService;
use Drupal\bgg_search\DataCleaning;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements bgg Search form.
 */
class BggSearchForm extends ConfigFormBase {

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
   * BggSearchForm constructor.
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
      $container->get('bgg_search.DataCleaning'),
    );
  }

  /**
   * {@inheritDoc}
   */
  protected function getEditableConfigNames(){
    return ['bgg_search.search_for_bgg'];
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId(){
    return 'bgg_search_form';
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('bgg_search.search_for_bgg');

    $form['found_boardgame'] = [
      '#type' => 'textfield',
      '#autocomplete_route_name' => 'bgg_search.autocomplete',
      '#title' => $this->t('Search For board game'),
      '#description' => $this->t('Type in a search term for a board game'),
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Add Game'),
      '#button_type' => 'primary',
    ];

    // By default, render the form using system-config-form.html.twig.
    $form['#theme'] = 'system_config_form';

    return $form;
  }

  /**
   * Takes in name of a boardgame and returns, false if nothing was returned, or
   * array containing title and id of that boardgame.
   *
   * @param $bggName
   * @return array|false
   */
  private function getBoardGame($bggName){
    $resp = $this->bggApi->SearchForBgg($bggName);
    if($resp){
      $bgg = [  'id'    => $resp['boardgame'][0]['@attributes']['objectid'],
              'title' => $resp['boardgame'][0]['name'] ];

      if ($bgg['id'] == null){
        $bgg['id'] = $resp['boardgame']['@attributes']['objectid'];
      }
      if ($bgg['title'] == null){
        $bgg['title'] = $resp['boardgame']['name'];
      }
      return $bgg;
    }
    else {
      return false;
    }

  }

  /**
   * Adds new boardgame to database, or updates existing boardgame if the game was allready found in the database
   *
   * @param $bgg
   * @return array
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  private function addGameToDatabase($bgg){

    $resp = $this->bggApi->GetBoardGameById($bgg['id']);

    $data = $this->DataCleaning->CleanBoardGameDataArray($resp, $bgg['title']);

    if ( $this->DataBaseService->Get($bgg['id']) != false) {
      if ($this->DataBaseService->Compare($bgg['id'], $data) == false){
        $this->DataBaseService->Update($bgg['id'], $data);
      }
    }
    else {
      $this->DataBaseService->Add($bgg['id'], $data);
    }

    return $data;
  }

  /**
   * {@inheritDoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $searchTerm = $form_state->getValue('found_boardgame');

    $bgg = $this->getBoardGame($searchTerm);
    if($bgg){
      $game = $this->addGameToDatabase($bgg);
      $this->messenger()->addStatus($this->t( '" '. $game['title'] . ' " Added To library.' ));

    }
    else {
      $this->messenger()->addError($this->t( '" ' .$searchTerm . ' " was not found!' ));
    }

  }
}
