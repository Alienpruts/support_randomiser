<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/6/16
 * Time: 4:49 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers;


use CalendR\Calendar;
use Slim\Http\Request;
use Slim\Http\Response;

class WeekController extends BaseController
{
    public function getWeek(Request $req, Response $res, $args)
    {
        // TODO : Currenty week is a Calendar week, not own Week model!
        // TODO : create seperate twig partial for this?
        // TODO : when changing years (week 52), year is not changed (ie. back to week 1 of current year)
        $date = date(' D d M Y');
        $week_nr = $args['weeknr'];
        $year = date('Y', time());
        $calendar = new Calendar();
        $week = $calendar->getWeek($year, $week_nr);
        $weeknrs = [
          'previous' => $week->getPrevious()->__toString(),
          'next' => $week->getNext()->__toString(),
        ];

        return $this->view->render($res, 'home.twig', [
          'week' => $week,
          'date' => $date,
          'weeknrs' => $weeknrs,
        ]);
    }
}