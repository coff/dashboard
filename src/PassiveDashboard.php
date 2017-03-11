<?php

namespace Casadatos\Component\Dashboard;

class PassiveDashboard extends ConsoleDashboard
{

    public function refresh($force = false)
    {
        /*
        does nothing since we do not update values multiple times for
        each log entry
        */

        return $this;
    }

    public function snap()
    {
        $gaugesStr = '|';

        foreach ($this->gauges as $key => $gauge) {
            $gaugesStr .= $this->colorize($this->colors[$key]) . $gauge->refresh(true) . $this->colorize(self::COL_FG_DEFAULT) . '|';
        }

        echo $gaugesStr . PHP_EOL;

        return $this;
    }
}
