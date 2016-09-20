<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 9/15/16
 * Time: 8:55 PM
 */

require_once (__DIR__ . ("/vendor/autoload.php"));
date_default_timezone_set('Europe/Brussels');

use Alienpruts\support_randomiser\Collection;
use Alienpruts\support_randomiser\Person;
use Alienpruts\support_randomiser\SupportWeek;
use CalendR\Calendar;

$test = new Person('test', 'test');

d($test);

$calendar = new Calendar();

$support_week = new SupportWeek($calendar);
$support_week->setWeek('2016', '38');
$support_week->setDays();
d($support_week->getDays());

d($support_week);
d($support_week->getCurrentWeek());

$person = new Person('test', 'testing');
$person2 = new Person('tester', 'Testeringer' );

$person->elevateSupportLevel(2);
$person2->lowerSupportLevel();
$collection = new Collection();
$collection->addContender($person);
$collection->addContender($person2);

d($person);
d($collection);

foreach ($collection->getContenders() as $contender) {
  d($contender->getSupportLevel());
}