<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 9/14/16
 * Time: 3:20 PM
 */
require_once (__DIR__ . ("/vendor/autoload.php"));
date_default_timezone_set('Europe/Brussels');
use CalendR\Calendar;

$calendar = new Calendar();
$calendar->setFirstWeekday(1);

$month = $calendar->getMonth(2016, 8);
d($calendar);
d($month);

$week = $calendar->getWeek(2016, 37);

foreach ($week as $day) {
  print ("<p> {$day->format('D m Y')} </p>");
  echo $day . ' ' . $day->format('d') . ' ' . $month;
  //d($day->format('D m Y'));
}
$nextweek = $week->getNext();

// get next week
d($nextweek);

$month = $calendar->getMonth(2012, 01) ?>

<table>
  <?php // Iterate over your month and get weeks ?>
  <?php foreach ($month as $week): ?>
    <tr>
      <?php // Iterate over your week and get days ?>
      <?php foreach ($week as $day): ?>
        <?php //Check days that are out of your month ?>
        <td<?php if (!$month->includes($day)) echo ' class="out-of-month"' ?>>
          <?php echo $day ?>
        </td>
      <?php endforeach ?>
    </tr>
  <?php endforeach ?>
</table>

<?php $week = $calendar->getWeek(2012, 14) ?>

<table>
  <thead>
  <tr>
    <?php foreach ($week as $day): ?>
      <th><?php echo $day ?></th>
    <?php endforeach ?>
  </tr>
  </thead>
  <tbody>
  <tr>
    <?php foreach ($week as $day): ?>
      <td>
        <?php // Retrieve your events, for exemple ?>
      </td>
    <?php endforeach ?>
  </tr>
  </tbody>
</table>




