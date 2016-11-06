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
        // TODO : current week is Calendar week, not own Week!
        $date = date(' D d M Y');
        $week_nr = date('W', time());
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