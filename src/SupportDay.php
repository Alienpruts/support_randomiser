<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 9/15/16
 * Time: 9:32 PM
 */

namespace Alienpruts\support_randomiser;


use CalendR\Calendar;

class SupportDay {

  private $calendar;
  private $day;

  /**
   * SupportDay constructor.
   */
  public function __construct( Calendar $calendar) {
    $this->calendar = $calendar;
  }

  public function setDay($year, $week, $day) {
    return $this->calendar->getDay($year, $week, $day);
  }


}