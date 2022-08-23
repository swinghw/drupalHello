<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 *  Provides a 'Hello' Block
 * 
 *  @Block(
 *    id = "hello_world_block",
 *    admin_label = @Translation("Hello block"),
 *    category = @Translation("Hello World"),
 * )
 */
class HelloBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {

      $config = $this->getConfiguration();

      if (!empty($config['hello_world_block_name'])) {
        $name = $config['hello_world_block_name'];
      }
      else {
        $name = $this->t('to no one');
      }

      $some_array = [
        0 => [
          'is_active' => 'active',
          'label' => 'Go! google',
          'url' => 'https://google.com',
        ],
        1 => [
          'is_active' => 'inactive',
          'label' => 'Search amazon',
          'url' => 'https://amazon.com',
        ],
      ];

      return [
        '#theme' => 'hello_world_block',
        '#active_tab' => 'some_string',
        '#tabs' => $some_array,
        '#body_text' => [
          '#markup' => $this->t('Hello @name!', [
            '@name' => $name,
          ]),
        ],
      ];

    }

  /**
   * {@inheritdoc}
   */ 
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['hello_world_block_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => $config['hello_world_block_name'] ?? '',
    ];

    return $form;
  }
  
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {

    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['hello_world_block_name'] = $values['hello_world_block_name'];
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    if ($form_state->getValue('hello_world_block_name') === 'John') {
      $form_state->setErrorByname('hello_world_block_name', $this->t('You can not say hello to John'));
    }
  }

}