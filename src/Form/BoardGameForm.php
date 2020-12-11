<?php

namespace Drupal\bgg_search\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;


/**
 * Form for creating/editing BoardGame entities.
 *
 * @package Drupal\bgg_search\Form
 */
class  BoardGameForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Product.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Product.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.boardgame.canonical', ['boardgame' => $entity->id()]);
  }
}
