<?php

namespace Casadatos\Component\Dashboard\Gauge;

class ByteGauge extends Gauge
{
    const
        SCALE_BASE = 1,
        SCALE_KILO = 1024,
        SCALE_MEGA = 1024*1024,
        SCALE_GIGA = 1024*1024*1024;

    protected $units = array (
        self::SCALE_BASE => '',
        self::SCALE_KILO => 'K',
        self::SCALE_MEGA => 'M',
        self::SCALE_GIGA => 'G',
    );

    protected $format;
    protected $fillChar = ' ';
    protected $pad;
    protected $scale;

    /**
     * ValueGauge constructor.
     *
     * @param int $length overall length of gauge
     * @param string $format sprintf-like format
     * @param int $pad one of STR_PAD_* constant values
     */
    public function __construct($length = 10, $format = "%.2f", $scale=self::SCALE_KILO, $pad = STR_PAD_LEFT)
    {
        $this->setLength($length);
        $this->format = $format.$this->units[$scale].'B';
        $this->pad = $pad;
        $this->scale = $scale;

        parent::__construct();
    }

    public function refresh($force=false)
    {


        return str_pad(
            substr(
                sprintf($this->format, $this->getValue() / $this->scale),
                -$this->getLength()
            ),
            $this->getLength(),
            $this->fillChar,
            $this->pad);
    }
}
