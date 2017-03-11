<?php

namespace Casadatos\Component\Dashboard;

use Casadatos\Component\Dashboard\Exception\DashboardException;
use Casadatos\Component\Dashboard\Gauge\Gauge;

class ConsoleDashboard extends Dashboard
{
    const
        COL_FG_DEFAULT      = '0;0',

        COL_FG_BLACK        = '0;30',
        COL_FG_DARKGRAY     = '1;30',

        COL_FG_RED          = '0;31',
        COL_FG_LIGHTRED     = '1;31',

        COL_FG_GREEN        = '0;32',
        COL_FG_LIGHTGREEN   = '1;32',

        COL_FG_BROWN        = '0;33',
        COL_FG_YELLOW       = '1;33',

        COL_FG_BLUE         = '0;34',
        COL_FG_LIGHTBLUE    = '1;34',

        COL_FG_PURPLE       = '0;35',
        COL_FG_LIGHTPURPLE  = '1;35',

        COL_FG_CYAN         = '0;36',
        COL_FG_LIGHTCYAN    = '1;36',

        COL_FG_LIGHTGRAY    = '0;37',
        COL_FG_WHITE        = '1;37',

        COL_BG_DEFAULT      = '0',

        EFF_BOLD            = '1',
        EFF_UNDERLINE       = '4',
        EFF_BLINK           = '5',

        COL_BG_BLACK        = '40',
        COL_BG_RED          = '41',
        COL_BG_GREEN        = '42',
        COL_BG_YELLOW       = '43',
        COL_BG_BLUE         = '44',
        COL_BG_MAGENTA      = '45',
        COL_BG_CYAN         = '46',
        COL_BG_LIGHTGRAY    = '47';

    protected $lastRefresh=null;
    protected $colors = array();

    public function add($gaugeName, Gauge $gauge, $title = null, $effect = self::COL_FG_DEFAULT) {
        $this->gauges[$gaugeName] = $gauge;
        $this->colors[$gaugeName] = $effect;

        if (!is_null($title)) {
            $this->headers[$gaugeName] = $title;
        } else
            $this->headers[$gaugeName] = $gaugeName;

        return $this;
    }

    public function printHeaders() {
        $headers = $this->getHeaders();

        if (!$this->gauges) {
            throw new DashboardException('No gauges added!');
        }

        $frames = array();
        foreach ($this->gauges as $gauge) {
            $frames[] = str_pad("", $gauge->getLength(), "-");
        }
        echo "\r";
        echo "+" . implode("+", $frames) . "+" . PHP_EOL;
        echo "|" . implode("|", $headers) . "|" . PHP_EOL;
        echo "+" . implode("+", $frames) . "+" . PHP_EOL;

        return $this;
    }

    public function summarize()
    {
        $frames = array();
        foreach ($this->gauges as $gauge) {
            $frames[] = str_pad("", $gauge->getLength(), "-");
        }

        $this->snap();

        echo "+" . implode("+", $frames) . "+" . PHP_EOL;

        return $this;
    }

    protected function colorize($color) {
        return "\033["  . $color . 'm';
    }

    public function refresh($force=false)
    {
        if (!is_null($this->lastRefresh) && $this->lastRefresh === time() && $force === false) {
            return $this;
        }

        $gaugesStr = '|';

        foreach ($this->gauges as $key => $gauge) {
            $gaugesStr .= $this->colorize($this->colors[$key]) . $gauge->refresh($force) . $this->colorize(self::COL_FG_DEFAULT) . '|';
        }

        echo $gaugesStr . "\r";

        $this->lastRefresh = time();

        return $this;
    }

    /**
     * Just makes a newline.
     * @return $this
     */
    public function snap()
    {
        echo PHP_EOL;
        return $this;
    }
}
