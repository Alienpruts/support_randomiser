<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 10/27/16
 * Time: 9:17 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

/**
 * @property Twig view
 */
class HomeController extends BaseController
{
    /**
     * Very simple version of WeekController, to show current Support Week
     *
     * @param \Slim\Http\Request $req
     * @param \Slim\Http\Response $res
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Request $req, Response $res)
    {
        $date = date(' D d M Y');
        $week_nr = date('W', time());
        $year = date('Y', time());
        $calendar = $this->calendar;
        $week = $calendar->getWeek($year, $week_nr);

        return $this->view->render($res, 'home.twig', [
          'week' => $week,
          'date' => $date,
        ]);
    }
}