<?php

namespace AppBundle\Helper;

/**
 * Roles helper displays roles set in config.
 */
class Roles
{
  private $rolesHierarchy;

  public function __construct($rolesHierarchy)
  {
    $this->rolesHierarchy = $rolesHierarchy;
  }

  /**
   * Return roles.
   *
   * @return array
   */
  public function getRoles()
  {
    $roles = array();

    array_walk_recursive($this->rolesHierarchy, function($val) use (&$roles) {
      $roles[] = $val;
    });

    return array_unique($roles);
  }
}
