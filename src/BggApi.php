<?php

namespace Drupal\bgg_search;

/**
 *
 * Handles API connections to and from boardgameGeek webservice
 *
 * Class BggApi
 * @package Drupal\bgg_search
 */
class BggApi {
  protected $page = 'https://www.boardgamegeek.com/xmlapi/';

  /**
   * Converts input xml into php Array element
   *
   * @param $Input
   * @return mixed
   */
  private function ConvertXmlToArray($Input) {

    $xml = simplexml_load_string($Input, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    return json_decode($json,TRUE);
  }

  /**
   * Cleans url by perfoming serch and replace on some url-unfriendly keys.
   *
   * @param $url
   * @return string
   */
  private function cleanUrl($url){
    $replace_pairs = array(
      "\t" => '%20',
      " " => '%20',
      ":" => ""
    );
    return strtr( $url, $replace_pairs);
  }

  /**
   * Searches the API and returns array witch as ids and names
   *
   * @param $searchTerm
   * @return false|mixed
   */
  public function SearchForBgg($searchTerm) {


    $url = $this->page . 'search?search=' . $this->cleanUrl($searchTerm);

    $rawContent = file_get_contents( $url );


    $bggItem = $this->ConvertXmlToArray($rawContent);

    if(!array_key_exists('boardgame',$bggItem)){
      return false;
    }
    return $bggItem;
  }

  /**
   * Finds details about certen bordgame from id
   *
   * @param $id
   * @return mixed
   */
  public function GetBoardGameById($id){

    $rawContent = file_get_contents($this->page . '/boardgame/' . $id );
    return $this->ConvertXmlToArray($rawContent);
  }

}
