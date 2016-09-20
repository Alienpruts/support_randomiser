<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 9/15/16
 * Time: 9:15 PM
 */

namespace Alienpruts\support_randomiser;


class Collection {

  private $contenders = [];

  // Get and set all available contenders (Person)
  // set and define guidelines for drawing a hand
  // draw a hand.

  /**
   * @param array $contenders
   */
  public function addContender( Person $contender) {
    $this->contenders[] = $contender;
  }

  /**
   * @return array
   */
  public function getContenders() {
    return $this->contenders;
  }
}