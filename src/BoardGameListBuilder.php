<?php

namespace Drupal\bgg_search;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * EntityListBuilderInterface implementation responsible for the BoardGame entities.
 */
class BoardGameListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc }
   */
  public function buildHeader() {
    $header['id'] = $this->t('Product ID');
    $header['title'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\products\Entity\BoardGame */
    $row['id'] = $entity->id();
    $row['title'] = $entity->toLink();
    return $row + parent::buildRow($entity);
  }
}
