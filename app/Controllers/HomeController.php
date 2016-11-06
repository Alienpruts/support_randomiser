<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 9:17 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers;

use CalendR\Calendar;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property Twig view
 */
class HomeController extends BaseController
{
    public function index(Request $req, Response $res)
    {
        // TODO : This controller is very similar to WeekController, but does not
        // have some advanced features like correct next, previous links.
        // REWORK, or replace by 'simple' week view?
        $date = date(' D d M Y');
        $week_nr = date('W', time());
        $year = date('Y', time());
        $calendar = new Calendar();
        $week = $calendar->getWeek($year, $week_nr);
        $iterations = [
          'previous' => $week->getPrevious()->__toString(),
          'next' => $week->getNext()->__toString(),
          'year' => $year,
        ];

        return $this->view->render($res, 'home.twig', [
          'week' => $week,
          'date' => $date,
          'iterations' => $iterations,
        ]);
    }
}