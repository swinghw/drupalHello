<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
      
      return [
        '#theme' => 'hello_world_block',
        '#data' => ['age' => '31', 'DOB' => '2 May 2000'],
      ];

    }

}