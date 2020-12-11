<?php

namespace Drupal\bgg_search;

/**
 * Handles communication to and from my internal database
 *
 * Class DataBaseService
 * @package Drupal\bgg_search
 */
class DataBaseService {

  /**
   * adds value to database
   *
   * @param $value
   * @param $entityType
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  private function addData($value, $entityType) {

    $node = \Drupal::entityTypeManager()->getStorage($entityType)->create($value);
    $node->save();
  }

  /**
   * Gets finds taxenomi item from given id and name
   *
   * @param $taxonomy
   * @return mixed|null
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  private function getTaxonomy($taxonomy){
    if($taxonomy['name'] == null){
      return null;
    }
    if($taxonomy['vid'] == null){
      return null;
    }
    $query = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->getQuery();

    $node_ids = $query
      ->condition('vid', $taxonomy['vid'])
      ->condition('name', $taxonomy['name'])
      ->execute();

    foreach ($node_ids as $id){
      return $id;
    }
    return null;
  }

  /**
   * Saves a file, based on it's type
   *
   * @param $url
   *   Full path to the image on the internet
   * @param $folder
   *   The folder where the image is stored on your hard drive
   * @param $type
   *   Type should be 'image' at all time for images.
   * @param $title
   *   The title of the image (like ALBUM_NAME - Cover), as it will appear in the Media management system
   * @param $basename
   *   The name of the file, as it will be saved on your hard drive
   *
   * @return int|null|string
   * @throws EntityStorageException
   */
  private function saveFile($url, $folder, $type, $title, $basename, $uid = 1) {
    if(!is_dir(\Drupal::config('system.file')->get('default_scheme').'://' . $folder)) {
      return null;
    }
    $destination = \Drupal::config('system.file')->get('default_scheme').'://' . $folder . '/'.basename($basename);
    if(!file_exists($destination)) {
      $file = file_get_contents($url);
      $file = file_save_data($file, $destination);
    }
    else {
      $file = \Drupal\file\Entity\File::create([
        'uri' => $destination,
        'uid' => $uid,
        'status' => FILE_STATUS_PERMANENT
      ]);

      $file->save();
    }

    $file->status = 1;

    $media_type_field_name = 'field_media_image';

    $media_array = [
      $media_type_field_name => $file->id(),
      'name' => $title,
      'bundle' => $type,
    ];
    if($type == 'image') {
      $media_array['alt'] = $title;
    }

    $media_object = \Drupal\media\Entity\Media::create($media_array);
    $media_object->save();
    return $media_object->id();
  }

  /**
   * Adds a entity to to a node in data base with type 'boardgame' and key $key
   *
   * @param $key
   * @param $value
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function Add($key,$value) {

    $Fields = [];
    foreach ($value as $key_Name => $value_name){
      if(is_array($value_name)){
        $fieldName = 'field_' . $key_Name;
        $Fields[$fieldName] = array();
        foreach ($value_name as $item){

          $taxonomy['vid'] = $key_Name;
          $taxonomy['name'] = $item;
          $id = $this->getTaxonomy($taxonomy);

          if($id != null){
            array_push($Fields[$fieldName], $id);
          }
          else {
            $this->addData($taxonomy,'taxonomy_term');
            $id = $this->getTaxonomy($taxonomy);
            array_push($Fields[$fieldName], $id);
          }
        }
      }
      else{
        $Fields['field_' . $key_Name] = $value_name;
      }
    }

    $entity = $Fields;
    $entity['type'] = 'boardgame';
    $entity['id'] = $key;
    $entity['title'] = $Fields['field_title'];
    unset($entity['field_title']);

    $images[] = $this->saveFile(
      $entity['field_bord_game_image'],
      '/',
      'image',
      $entity['title'],
      $entity['title'] . '.jpg');
    $entity['field_bord_game_image'] = $images;

    $this->addData($entity,'boardgame');
  }

  /**
   * Gets element from enity manager where key is $key
   * should only return single results, returns false if there is nothing
   *
   * @param $key
   * @return array|false|int
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function Get($key){

    $node = \Drupal::entityTypeManager()->getStorage('boardgame')->load($key);

    if(empty($node)){
      return false; // TODO! Er til eh eins og return NULL
    } else {
      return $node->getFields(); //TODO! Hreynsa þetta eitthvað þarf að finna ut nákvæmlega hvað kemur út
                     // Vill skila þessu eins og $value
    }
  }

  /**
   * compares if result in databas is the same as input results
   *
   * @param $key
   * @param $value
   * @return bool
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function Compare($key,$value){
    $dbVal = $this->Get($key);
    foreach ( $value as $columnName => $item ){
      if( $dbVal[$columnName]->value != $item ){
        return false;
      }
    }
    return true;
  }

  /**
   * Deletes ar $key and inserts new data at $key with value $value
   *
   * @param $key
   * @param $value
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function Update($key,$value){
    $node = \Drupal::entityTypeManager()->getStorage('boardgame')->load($key);
    $node->delete();
    $this->Add($key,$value);
  }
}
