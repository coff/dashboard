<?php

namespace Casadatos\Component\Dashboard\Gauge;

class ValueSpeedGauge extends Gauge
{
    const
        SCALE_HOURS   = 3600,
        SCALE_MINUTES = 60,
        SCALE_SECONDS = 1;

    protected $units = array (
        self::SCALE_HOURS => 'h',
        self::SCALE_MINUTES => 'm',
        self::SCALE_SECONDS => 's'
    );

    protected $scale;
    protected $fillChar = ' ';

    protected $format;
    protected $pad;
    protected $speed;
    protected $probes;
    protected $p0;
    protected $v0;

    public function __construct($length = 10, $scale = self::SCALE_MINUTES, $format = "%.2f", $pad = STR_PAD_LEFT)
    {
        $this->setLength($length);
        $this->format = $format;
        $this->scale = $scale;
        $this->pad = $pad;
    }

    public function init() {
        $this->p0 = array(microtime(true), $this->getValue());
        $this->probes[] = array($this->p0[0], $this->getValue());
    }

    public function refresh($force=false)
    {
        $t = microtime(true);
        $this->probes[] = array ($t,$this->getValue());

        if (count($this->probes) > 60) {
            array_shift($this->probes);
        }

        if ($force) {
            list($t0, $v0) = $this->p0;
        } else {
            list($t0, $v0) = reset($this->probes);
        }

        $timeDelta = $t - $t0;
        $valueDelta = $this->getValue() - $v0;

        $this->speed = ($valueDelta / $timeDelta)*$this->scale;

        return str_pad(
            substr(
                sprintf($this->format, $this->speed),
                0,
                $this->getLength()
            ),
            $this->getLength(),
            $this->fillChar,
            $this->pad);
    }
}
