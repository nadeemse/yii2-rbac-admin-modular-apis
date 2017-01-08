<?php

namespace common\helpers;

use Yii;
use \yii\db\Expression;

class DateTimeHelper
{
    public function __construct() {
        date_default_timezone_set("Asia/Dubai");
    }

    public function getCurrentDateTime() {
        return new Expression('NOW()');
    }

    public static function getTime()
    {
        $time = new \DateTime('now');
        return $time->format('Y-m-d H:i:s');
    }

    public static function getDate()
    {
        $time = new \DateTime('now');
        return $time->format('Y-m-d');
    }

    public function orderDate($date) {

        return date('Y-m-d\TH:i:s', strtotime($date));

    }

    /* get past minutes
     * getPastMinutes is a function that will return past minutes
     * @params integer $minutes
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     * @returns string past x minutes time
     * */
    public function getPastMinutes($minute) {

        return date('H:i:s', strtotime($minute.' minutes'));
    }

    /* get readable time from date and time
     * getReadableTime is used to return time from date and time
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     * @params DATETIME $date
     * @returns TIME
     * */
    public function getReadableTime($date) {
        return date("H",strtotime($date));
    }

    /* Get TimeStamp from date and time
     *
     *
     * */

    public function getTimeStamp($time) {
        return strtotime($time);
    }

    /* get readable minutes and seconds from seconds
     * @params integer $seconds
     * @returns string $time
     * */

    public function getSecondToHoursSecond($seconds) {
        $s = $seconds%60;
        $m = floor(($seconds%3600)/60);
        return "$m min, $s sec";

    }

    /* validate time in between
     *
     * */

    public function validateInBetween($from, $to) {

        $time = new \DateTime('now');
        $cur_time = $time->format('H:i:s');

        $st_time    =   strtotime($from);
        $end_time   =   strtotime($to);
        $cur_time   =   strtotime($cur_time);

        if($cur_time >= $st_time && $cur_time <= $end_time) {
            return true;
        } else {
            return false;
        }

    }
    /* Get time difference
     *
     * */

    public function getTimeDiffrence($created_time, $driver_time) {

        if(!empty($driver_time)) {

            $to_time = strtotime($created_time);
            $from_time = strtotime($driver_time);

            $etime = abs($to_time - $from_time);

            if ($etime < 1)
            {
                return '0 seconds';
            }

            $a = array( 365 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60  =>  'month',
                24 * 60 * 60  =>  'day',
                60 * 60  =>  'hour',
                60  =>  'minute',
                1  =>  'second'
            );
            $a_plural = array( 'year'   => 'years',
                'month'  => 'months',
                'day'    => 'days',
                'hour'   => 'hours',
                'minute' => 'minutes',
                'second' => 'seconds'
            );

            foreach ($a as $secs => $str)
            {
                $d = $etime / $secs;
                if ($d >= 1)
                {
                    $r = round($d);
                    return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
                }
            }


        } else {
            return 'N/A';
        }


    }

    public function getReadableFormat($date) {
        return date("F jS, Y",strtotime($date));
    }

    public function getMonth($date) {
        return date("F",strtotime($date));
    }

    public function getReadableDateAndTimeFormat($dateTime, $format = 'M j, Y G:i:s') {

        return date($format,strtotime($dateTime));
//        return date("F jS, Y, g:i a",strtotime($dateTime));
    }

    /* get Read able time
     * ~~~
     * Like : 4:30 AM, 4:40 PM
     * ~~~
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     * */
    public function getTimeFormat($time) {

        return date("g:i a",strtotime($time));
    }

    public function getAgoTime($dateTime)
    {
        $etime = time() - strtotime($dateTime);

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
        );
        $a_plural = array( 'year'   => 'years',
            'month'  => 'months',
            'day'    => 'days',
            'hour'   => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

    /* get Current day
     * this function will return current day from today
     * */

    public function getCurrentDay() {
        return date("l");
    }
}