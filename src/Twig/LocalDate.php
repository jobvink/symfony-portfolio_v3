<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 30-10-17
 * Time: 20:44
 */

namespace App\Twig;


use Carbon\Carbon;
use Twig_Extension;

class LocalDate extends Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('localdate', array($this, 'convert')),
        );
    }

    public function convert($date, $locale = 'nl', $format = null)
    {
        if (!$date) return null;
        $output = Carbon::instance($date);
        Carbon::setLocale($locale);
        $output->setTimezone('Europe/Amsterdam');

        if (!is_null($format)) {
            setlocale(LC_TIME, 'nl_NL');
            $output = $output->formatLocalized($format);
        } else {
            setlocale(LC_TIME, 'nl_NL');
            $output = $output->formatLocalized('%B %Y');
        }
        return $output;
    }
}