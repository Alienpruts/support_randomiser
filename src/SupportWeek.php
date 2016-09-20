<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 9/15/16
 * Time: 9:21 PM
 */

namespace Alienpruts\support_randomiser;


use CalendR\Calendar;

class SupportWeek {

  private $days;
  private $calendar;
  private $week;

  /**
   * SupportWeek constructor.
   */
  public function __construct( Calendar $calendar) {
    $this->calendar = $calendar;
  }

  public function setWeek($year, $week) {
    $this->week = $this->calendar->getWeek($year, $week);
  }

  public function getCurrentWeek() {
    return $this->week;

  }

  /**
   * @return \CalendR\Calendar
   */
  public function setDays() {
    foreach ($this->week as $day) {
      //call supportDay constructor
      $supportDay = new SupportDay($this->calendar);
      $this->days[] = $supportDay->setDay($day->format('Y'), $day->format('m'), $day->format('d'));
    }
  }

  public function getDays() {
    return $this->days;
  }


}