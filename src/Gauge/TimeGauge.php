<?php

namespace Casadatos\Component\Dashboard\Gauge;

class TimeGauge extends Gauge
{
    protected $format;
    protected $fillChar = ' ';
    protected $pad;

    protected $isResetable = true;

    public function __construct($length = 13, $format = "%.2fs", $pad = STR_PAD_LEFT)
    {
        $this->setLength($length);
        $this->format = $format;
        $this->pad = $pad;
    }



    public function refresh($force=false)
    {

        return str_pad(
            substr(
                sprintf($this->format, $this->getValue()),
                -$this->getLength()
            ),
            $this->getLength(),
            $this->fillChar,
            $this->pad);
    }
}
