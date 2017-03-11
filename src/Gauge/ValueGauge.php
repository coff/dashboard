<?php

namespace Casadatos\Component\Dashboard\Gauge;

class ValueGauge extends Gauge
{
    protected $format;
    protected $fillChar = ' ';
    protected $pad;

    /**
     * ValueGauge constructor.
     *
     * @param int $length overall length of gauge
     * @param string $format sprintf-like format
     * @param int $pad one of STR_PAD_* constant values
     */
    public function __construct($length = 10, $format = "%s", $pad = STR_PAD_LEFT)
    {
        $this->setLength($length);
        $this->format = $format;
        $this->pad = $pad;

        parent::__construct();
    }

    public function refresh($force=false)
    {
        return str_pad(
            substr(
                sprintf($this->format, $this->getValue()),
                0,
                $this->getLength()
            ),
            $this->getLength(),
            $this->fillChar,
            $this->pad);
    }
}
