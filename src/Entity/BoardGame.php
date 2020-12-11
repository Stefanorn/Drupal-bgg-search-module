<?php

namespace Drupal\bgg_search\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the BoardGame entity.
 **
 * @ContentEntityType(
 *   id = "boardgame",
 *   label = @Translation("Boardgame"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bgg_search\BoardgameListBuilder",
 *
 *     "form" = {
 *       "default" = "Drupal\bgg_search\Form\BoardgameForm",
 *       "add" = "Drupal\bgg_search\Form\BoardgameForm",
 *       "edit" = "Drupal\bgg_search\Form\BoardgameForm",
 *       "delete" = "Drupal\bgg_search\Form\BoardgameDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "boardgame",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/boardgame/{boardgame}",
 *     "add-form" = "/admin/structure/boardgame/add",
 *     "edit-form" = "/admin/structure/boardgame/{boardgame}/edit",
 *     "delete-form" = "/admin/structure/boardgame/{boardgame}/delete",
 *     "collection" = "/admin/structure/boardgame",
 *   },
 * )
 */
class BoardGame extends ContentEntityBase implements BoardGameInterface {
  use EntityChangedTrait;


  /**
   * Gets Title
   */
  public function getTitle() {
    return $this->get('title')->value;
  }
  /**
   * Sets Title
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * Gets Maxplayers
   */
  public function getMaxplayers(){
    return $this->get('field_maxplayers')->value;
  }

  /**
   * Sets Maxplayers
   */
  public function setMaxplayers($maxplayers) {
    $this->set('field_maxplayers', $maxplayers);
    return $this;
  }

  /**
   * gets Description
   */
  public function getDescription() {
    return $this->get('field_description')->value;
  }

  /**
   * Sets Description
   */
  public function setDescription($description) {
    $this->set('field_description', $description);
    return $this;
  }

  /**
   * Gets MinPlayers
   */
  public function getMinPlayers() {
    return $this->get('field_minplayers')->value;
  }

  /**
   * Sets MinPlayers
   */
  public function setMinPlayers($minplayers){
    $this->set('field_minplayers', $minplayers);
    return $this;
  }

  /**
   * Gets BordGameImage
   */
  public function getBordGameImage() {
    return $this->get('field_bord_game_image')->value;
  }

  /**
   * Sets BordGameImage
   */
  public function setBordGameImage($bordGameImage){
    $this->set('field_bord_game_image', $bordGameImage);
    return $this;
  }

  /**
   * Gets BoardGamePublisher
   */
  public function getBoardGamePublisher()
  {
    return $this->get('field_boardgamepublisher')->value;
  }

  /**
   * Sets BoardGamePublisher
   */
  public function setBoardGamePublisher($boardgamepublisher){
    $this->set('field_boardgamepublisher', $boardgamepublisher);
    return $this;
  }

  /**
   * Gets BoardGameMechanic
   */
  public function getBoardGameMechanic() {
    return $this->get('field_boardgamemechanic')->value;
  }

  /**
   * Sets BoardGameMechanic
   */
  public function setBoardGameMechanic($boardgamemechanic){
    $this->set('field_boardgamemechanic', $boardgamemechanic);
    return $this;
  }

  /**
   * Gets BoardGameArtist
   */
  public function getBoardGameArtist(){
    return $this->get('field_boardgameartist')->value;
  }

  /**
   * Sets BoardGameArtist
   */
  public function setBoardGameArtist($boardgameartist){
    $this->set('field_boardgameartist', $boardgameartist);
    return $this;
  }

  /**
   * Gets BoardGameImplementation
   */
  public function getBoardGameImplementation(){
    return $this->get('field_boardgameimplementation')->value;
  }

  /**
   * Sets BoardGameImplementation
   */
  public function setBoardGameImplementation($boardgameimplementation){
    $this->set('field_boardgameimplementation', $boardgameimplementation);
    return $this;
  }

  /**
   * Gets BoardGameImplementation
   */
  public function getBoardGamedesigner(){
    return $this->get('field_boardgamedesigner')->value;
  }

  /**
   * Sets BoardGameImplementation
   */
  public function setBoardGamedesigner($boardgamedesigner)
  {
    $this->set('field_boardgamedesigner', $boardgamedesigner);
    return $this;
  }

  /**
   * Gets RemoteId
   */
  public function getRemoteId() {
    return $this->get('remote_id')->value;
  }

  /**
   * Sets RemoteId
   */
  public function setRemoteId($id) {
    $this->set('remote_id', $id);
    return $this;
  }

  /**
   * Gets Source
   */
  public function getSource() {
    return $this->get('source')->value;
  }

  /**
   * Sets Source
   */
  public function setSource($source) {
    $this->set('source', $source);
    return $this;
  }

  /**
   * Sets CreatedTime
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * Sets CreatedTime
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * Defines the database sceme
   *
   * @param EntityTypeInterface $entity_type
   * @return array|\Drupal\Core\Field\FieldDefinitionInterface[]
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('title'))
      ->setDescription(t('The title of the Product.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['field_description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDescription(t('A description of the BoardGame'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', array(
        'type' => 'text_textfield',
        'weight' => 0,
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['field_boardgamedesigner'] = BaseFieldDefinition::create('string')
      ->setLabel(t('title'))
      ->setDescription(t('The boardgamedesigner of the game.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);


    $fields['field_maxplayers'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Number'))
      ->setDescription(t('The maximum players.'))
      ->setSettings([
        'min' => 1,
        'max' => 10000
      ])
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_unformatted',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['field_boardgamepublisher'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('boardgamepublisher'))
      ->setDescription(t('boardgame publisher'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setCustomStorage(TRUE);

    $fields['field_boardgamemechanic'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('boardgamemechanic'))
      ->setDescription(t('boardgame mechanic'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setCustomStorage(TRUE);

    $fields['field_boardgameartist'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('boardgameartist'))
      ->setDescription(t('boardgame artist'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setCustomStorage(TRUE);

    $fields['field_boardgameimplementation'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('boardgameimplementation'))
      ->setDescription(t('boardgame implementation'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setCustomStorage(TRUE);

    $fields['field_boardgamepublisher'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('boardgamepublisher'))
      ->setDescription(t('boardgame publisher'))
      ->setSetting('target_type', 'taxonomy_term')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setCustomStorage(TRUE);

    $fields['remote_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Remote ID'))
      ->setDescription(t('The remote ID of the Product.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('');

    $fields['field_minplayers'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Number'))
      ->setDescription(t('The minimum players.'))
      ->setSettings([
        'min' => 1,
        'max' => 10000
      ])
      ->setDefaultValue(NULL)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'number_unformatted',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['field_bord_game_image'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('board Game Image'))
      ->setDescription(t('Image Of the boardGame.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setRequired(FALSE)
      ->setSetting('target_type', 'media')
      ->setSetting('handler', 'default:media')
      ->setSettings([
        'handler_settings' => [
          'target_bundles' => [
            'image' => 'image',
          ],
          'sort' => [
            'field' => '_none',
          ],
          'auto_create' => FALSE,
          'auto_create_bundle' => '',
        ],
      ])
      ->setCardinality(1)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', [
        'settings' => [
          'entity_browser' => 'image_browser',
          'field_widget_display' => 'rendered_entity',
          'field_widget_edit' => TRUE,
          'field_widget_remove' => TRUE,
          'open' => TRUE,
          'selection_mode' => 'selection_append',
          'field_widget_display_settings' => [
            'view_mode' => 'default',
          ],
          'field_widget_replace' => FALSE,
        ],
        'type' => 'entity_browser_entity_reference',
        'weight' => 3,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'settings' => [
          'target_type' => 'media',
        ],
        'weight' => 3,
      ]);

    $fields['remote_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Remote ID'))
      ->setDescription(t('The remote ID of the Product.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('');


    $fields['source'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Source'))
      ->setDescription(t('The source of the Product.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('');
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
