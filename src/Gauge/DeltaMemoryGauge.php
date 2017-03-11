<?php

namespace Casadatos\Component\Dashboard\Gauge;

class DeltaMemoryGauge extends ByteGauge
{
    protected $memoryUsageAtInit;

    public function __construct($length = 12, $format = "%.2f", $scale=self::SCALE_MEGA, $pad = STR_PAD_LEFT)
    {
        parent::__construct($length, $format, $scale, $pad);
    }

    public function init() {
        $this->memoryUsageAtInit = memory_get_usage();
    }

    public function refresh($force=false)
    {
        $this->update(memory_get_usage()-$this->memoryUsageAtInit);
        return parent::refresh($force);
    }
}
