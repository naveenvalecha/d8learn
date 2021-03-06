<?php

namespace Drupal\uc_wishlist;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Routing\RedirectDestinationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a class to build a listing of wishlist entities.
 *
 * @see \Drupal\uc_wishlist\Entity\UcWishlist
 */
class UcWishlistListBuilder extends EntityListBuilder {

  /**
   * The entity query factory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $queryFactory;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The redirect destination service.
   *
   * @var \Drupal\Core\Routing\RedirectDestinationInterface
   */
  protected $redirectDestination;

  /**
   * Constructs a new UcWishlistListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The entity query factory.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Drupal\Core\Routing\RedirectDestinationInterface $redirect_destination
   *   The redirect destination service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, QueryFactory $query_factory, DateFormatterInterface $date_formatter, RedirectDestinationInterface $redirect_destination) {
    parent::__construct($entity_type, $storage);
    $this->queryFactory = $query_factory;
    $this->dateFormatter = $date_formatter;
    $this->redirectDestination = $redirect_destination;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('entity.query'),
      $container->get('date.formatter'),
      $container->get('redirect.destination')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function load() {
    $entity_query = $this->queryFactory->get('uc_wishlist');
    $entity_query->pager(50);
    $header = $this->buildHeader();
    $entity_query->tableSort($header);
    $uids = $entity_query->execute();
    return $this->storage->loadMultiple($uids);
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = array(
      'title' => array(
        'data' => $this->t('Title'),
        'field' => 'title',
        'specifier' => 'title',
      ),
      'expiration' => array(
        'data' => $this->t('Expiration date'),
        'field' => 'expiration',
        'specifier' => 'expiration',
        'class' => array(RESPONSIVE_PRIORITY_LOW),
      ),
      'address' => array(
        'data' => $this->t('Address'),
        'field' => 'address',
        'specifier' => 'address',
        'class' => array(RESPONSIVE_PRIORITY_LOW),
      ),
      'private' => array(
        'data' => $this->t('Private'),
        'field' => 'private',
        'specifier' => 'private',
        'class' => array(RESPONSIVE_PRIORITY_LOW),
      ),
      'description' => array(
        'data' => $this->t('Description'),
        'field' => 'description',
        'specifier' => 'description',
        'class' => array(RESPONSIVE_PRIORITY_LOW),
      ),
    );
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = $entity->getTitle();
    $row['expiration'] = $entity->getExpirationTime();
    $row['address'] = $entity->getAddress();
    $row['private'] = $entity->getPrivate();
    $row['description'] = $entity->getDescription();

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getOperations(EntityInterface $entity) {
    $operations = parent::getOperations($entity);
    if (isset($operations['edit'])) {
      $destination = $this->redirectDestination->getAsArray();
      $operations['edit']['query'] = $destination;
    }
    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();
    $build['table']['#empty'] = $this->t('No wish lists found.');
    return $build;
  }

}
