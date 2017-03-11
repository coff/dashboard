<?php

namespace Casadatos\Component\Dashboard\Gauge;

class FreeMemoryGauge extends ByteGauge
{
    protected $memoryLimit;

    public function __construct($length = 12, $format = "%.2f", $scale=self::SCALE_MEGA, $pad = STR_PAD_LEFT)
    {
        $this->memoryLimit = ini_get('memory_limit');

        switch (substr($this->memoryLimit,-1)) {
            case 'K': $this->memoryLimit*=1024; break;
            case 'M': $this->memoryLimit*=1024*1024; break;
            case 'G': $this->memoryLimit*=1024*1024*1024; break;
        }

        parent::__construct($length, $format, $scale, $pad);
    }

    public function refresh($force=false)
    {
        $this->update($this->memoryLimit-memory_get_usage(true));
        return parent::refresh($force);
    }
}
