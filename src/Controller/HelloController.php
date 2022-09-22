<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Command\Guzzle\Deserializer;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines HelloController class.
 */
class HelloController extends ControllerBase {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   * 
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->database = $container->get('database');
    return $instance;
  }

  /**
   * Remove broken module entry from config table
   * 
   * @return string
   *   Return Hello string
   */
  public function removeModule() {
    // $query select data from config where name = 'core.extension'
    $query = $this->database->select('config', 'c');
    $query->condition('c.name', 'core.extension')->fields('c',['data']);
    $result = $query->execute()->fetchField();
    $arrayResult = unserialize($result);

    foreach ($arrayResult['module'] as $key => $value) {
      // the name of module to remove: media_gallery
      if ($key == 'media_gallery') {
        unset($arrayResult['module']['media_gallery']);
      }
    }

    $updated = serialize($arrayResult);

    $this->database
    ->update('config')
    ->fields(['data' => $updated])
    ->condition('name', 'core.extension')
    ->execute();

    return [
      '#type' => 'markup',
      '#markup' => $updated,
    ];
  }

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    ];
  }

}