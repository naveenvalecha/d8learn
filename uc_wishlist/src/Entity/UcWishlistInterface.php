<?php

namespace Drupal\uc_wishlist\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a wishlist entity.
 */
interface UcWishlistInterface extends ContentEntityInterface, EntityOwnerInterface {

  /**
   * Returns the wishlist title.
   *
   * @return string
   *   The wishlist title.
   */
  public function getTitle();

  /**
   * Sets the title for the wishlist.
   *
   * @param string $title
   *   The wishlist title.
   *
   * @return $this
   */
  public function setTitle($title);

  /**
   * Returns the wishlist expiration timestamp.
   *
   * @return int
   *   The wishlist expiration timestamp.
   */
  public function getExpirationTime();

  /**
   * Sets the expiration timestamp for the wishlist.
   *
   * @param int $expiration
   *   The wishlist expiration timestamp.
   *
   * @return $this
   */
  public function setExpirationTime($expiration);

  /**
   * Returns the wishlist address.
   *
   * @return string
   *   The wishlist address.
   */
  public function getAddress();

  /**
   * Sets the address for the wishlist.
   *
   * @param string $address
   *   The wishlist address.
   *
   * @return $this
   */
  public function setAddress($address);

  /**
   * Returns the wishlist private status.
   *
   * @return int
   *   The wishlist private status.
   */
  public function getPrivate();

  /**
   * Sets the private status for the wishlist.
   *
   * @param string $description
   *   The wishlist description.
   *
   * @return $this
   */
  public function setPrivate($description);

  /**
   * Returns the wishlist description.
   *
   * @return string
   *   The wishlist description.
   */
  public function getDescription();

  /**
   * Sets the description for the wishlist.
   *
   * @param string $description
   *   The wishlist description.
   *
   * @return $this
   */
  public function setDescription($description);

  /**
   * Get the user id this wishlist belongs to.
   *
   * @return int
   *   The id of the user.
   */
  public function getUserId();

}
