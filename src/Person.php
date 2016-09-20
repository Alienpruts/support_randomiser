<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 9/15/16
 * Time: 8:37 PM
 */

namespace Alienpruts\support_randomiser;


/**
 * Class Person
 * @package Alienpruts\support_randomiser
 */
class Person {

  private $voornaam;
  private $achternaam;
  private $support_level = 0;


  /**
   * @return mixed
   */
  public function getVoornaam() {
    return $this->voornaam;
  }

  /**
   * @param mixed $voornaam
   */
  public function setVoornaam($voornaam) {
    $this->voornaam = $voornaam;
  }

  /**
   * @return mixed
   */
  public function getAchternaam() {
    return $this->achternaam;
  }

  /**
   * @param mixed $achternaam
   */
  public function setAchternaam($achternaam) {
    $this->achternaam = $achternaam;
  }

  /**
   * Person constructor.
   * @param $voornaam
   * @param $achternaam
   */
  public function __construct($voornaam, $achternaam) {
    $this->voornaam = $voornaam;
    $this->achternaam = $achternaam;
  }

  public function resetSupportLevel() {
    $this->support_level = 0;
  }

  public function elevateSupportLevel($step = 1) {
    $this->support_level += $step;
  }

  public function lowerSupportLevel($step = 1) {
    $this->support_level -= $step;
  }

  /**
   * @return int
   */
  public function getSupportLevel() {
    return $this->support_level;
  }


}