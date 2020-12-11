<?php

namespace Drupal\bgg_search;

/**
 * Handlse cleaning of misulanis dataelemnts and returning
 * simpler machin readable data
 *
 * Class DataCleaning
 * @package Drupal\bgg_search
 */
class DataCleaning {

  /**
   * Transforms elemnen into array if it is not a array
   *
   * @param $elem
   * @return array|null
   */
  public function GenerateArray($elem){

    if($elem == null){
      return null;
    }

    if(is_array($elem)){
      return $elem;
    }
    else{
      return [$elem];
    }

  }

  /**
   * Cleans Bord Game data elements and returns only element are intended to be used in this program
   *
   * @param $BoardGameArray
   * @param string $title
   * @return array
   */
  public function CleanBoardGameDataArray($BoardGameArray, $title = ""){

    if($title == ""){
      if (is_array($BoardGameArray['boardgame']['name'])){
        $title = $BoardGameArray['boardgame']['name'][0];
      } else {
        $title = $BoardGameArray['boardgame']['name'];
      }
    }

    $cleanedArray = [
      "title"                   => $title,
      "maxplayers"              => $BoardGameArray['boardgame']['maxplayers'],
      "description"             => $BoardGameArray['boardgame']['description'],
      "minplayers"              => $BoardGameArray['boardgame']['minplayers'],
      "bord_game_image"         => $BoardGameArray['boardgame']['image'],
      "boardgamepublisher"      => $this->GenerateArray($BoardGameArray['boardgame']['boardgamepublisher']),
      "boardgamemechanic"       => $this->GenerateArray($BoardGameArray['boardgame']['boardgamemechanic']),
      "boardgameartist"         => $this->GenerateArray($BoardGameArray['boardgame']['boardgameartist']),
      "boardgameimplementation" => $this->GenerateArray($BoardGameArray['boardgame']['boardgameimplementation']),
      "boardgamedesigner"       => $BoardGameArray['boardgame']['boardgamedesigner'],
      ];

    return $cleanedArray;
  }
}
