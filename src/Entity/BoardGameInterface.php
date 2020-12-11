<?php

namespace Drupal\bgg_search\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Interface BoardGameInterface
 * @package Drupal\bgg_search\Entity
 */
interface BoardGameInterface extends ContentEntityInterface, EntityChangedInterface {

  public function getTitle();
  public function setTitle($title);

  public function getMaxplayers();
  public function setMaxplayers($maxplayers);

  public function getDescription();
  public function setDescription($description);

  public function getMinPlayers();
  public function setMinPlayers($minplayers);

  public function getBordGameImage();
  public function setBordGameImage($bordGameImage);

  public function getBoardGamePublisher();
  public function setBoardGamePublisher($boardgamepublisher);

  public function getBoardGameMechanic();
  public function setBoardGameMechanic($boardgamemechanic);

  public function getBoardGameArtist();
  public function setBoardGameArtist($boardgameartist);

  public function getBoardGameImplementation();
  public function setBoardGameImplementation($boardgameimplementation);

  public function getBoardGamedesigner();
  public function setBoardGamedesigner($boardgamedesigner);

  /**
   * Gets the Product remote ID.
   *
   * @return string
   */
  public function getRemoteId();
  /**
   * Sets the Product remote ID.
   *
   * @param string $id
   *
   * @return \Drupal\products\Entity\ProductInterface
   *   The called Product entity.
   */
  public function setRemoteId($id);
  /**
   * Gets the Product source.
   *
   * @return string
   */
  public function getSource();
  /**
   * Sets the Product source.
   *
   * @param string $source
   *
   * @return \Drupal\products\Entity\ProductInterface
   *   The called Product entity.
   */
  public function setSource($source);
  /**
   * Gets the Product creation timestamp.
   *
   * @return int
   */
  public function getCreatedTime();
  /**
   * Sets the Product creation timestamp.
   *
   * @param int $timestamp
   *
   * @return \Drupal\products\Entity\ProductInterface
   *   The called Product entity.
   */
  public function setCreatedTime($timestamp);
}
