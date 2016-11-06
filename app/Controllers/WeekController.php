<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 11/6/16
 * Time: 4:49 PM
 */

namespace Alienpruts\SupportRandomiser\Controllers;


use CalendR\Calendar;
use CalendR\Exception;
use CalendR\Period\PeriodInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class WeekController extends BaseController
{
    public function getWeek(Request $req, Response $res, $args)
    {
        // TODO : Currenty week is a Calendar week, not own Week model!
        // TODO : when changing years (week 52), year is not changed (ie. back to week 1 of current year)
        $date = date(' D d M Y');
        $week_nr = $args['weeknr'];
        $year = isset($args['year']) ? $args['year'] : date('Y', time());
        $calendar = new Calendar();
        // TODO : let Router handle exceptions (now Slim handles it)
        try {
            $week = $calendar->getWeek($year, $week_nr);
        } catch (Exception $e) {
            var_dump('test');
        }
        $iterations = [
          'previous' => [
            'week' => $week->getPrevious()->__toString(),
            'year' => $this->determineYear($week->getPrevious(), 'prev'),
          ],
          'next' => [
            'week' => $week->getNext()->__toString(),
            'year' => $this->determineYear($week->getNext(), 'next'),
          ]
        ];

        return $this->view->render($res, 'support_week.twig', [
          'week' => $week,
          'date' => $date,
          'iterations' => $iterations,
        ]);
    }

    /**
     * Determine which Year to send to the template.
     *
     * Useful for next / previous links which will increase/decrease the year.
     *
     * @param \CalendR\Period\PeriodInterface $week
     *  The PeriodInterface Week to perform colculations on.
     * @param $mode
     *  What period needs to be checked : 'prev' for previous week / 'next' for next week.
     * @return string Returns a string containing the Year Period to send to the template.
     *  Returns a string containing the Year Period to send to the template.
     */
    public function determineYear(PeriodInterface $week, $mode)
    {
        $start_year = $week->getBegin()->format('Y');
        $end_year = $week->getEnd()->format('Y');

        switch ($mode) {

            case 'next':
                return $end_year > $start_year ? $end_year : $start_year;
                break;
            case 'prev':
                return $start_year < $end_year ? $start_year : $end_year;
                break;
            default:
                //TODO : throw Exception?
        }
    }
}