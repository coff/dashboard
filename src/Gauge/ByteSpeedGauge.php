<?php

namespace Casadatos\Component\Dashboard\Gauge;

class ByteSpeedGauge extends Gauge
{
    const
        SCALE_BASE = 1,
        SCALE_KILO = 1024,
        SCALE_MEGA = 1024*1024,
        SCALE_GIGA = 1024*1024*1024,
        SCALE_HOURS   = 3600,
        SCALE_MINUTES = 60,
        SCALE_SECONDS = 1;

    protected $units = array (
        self::SCALE_BASE => '',
        self::SCALE_KILO => 'K',
        self::SCALE_MEGA => 'M',
        self::SCALE_GIGA => 'G',
    );

    protected $format;
    protected $fillChar = ' ';
    protected $pad;

    protected $speed;
    protected $probes;
    protected $p0;
    protected $v0;

    protected $timeScale, $byteScale;

    /**
     * ValueGauge constructor.
     *
     * @param int $length overall length of gauge
     * @param string $format sprintf-like format
     * @param int $pad one of STR_PAD_* constant values
     */
    public function __construct($length = 10, $byteScale=self::SCALE_KILO, $timeScale=self::SCALE_SECONDS, $format = "%.2f", $pad = STR_PAD_LEFT)
    {
        $this->setLength($length);
        $this->format = $format.$this->units[$byteScale].'B';
        $this->pad = $pad;
        $this->timeScale = $timeScale;
        $this->byteScale = $byteScale;

        parent::__construct();
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

        $this->speed = ($valueDelta / $this->byteScale) / ($timeDelta / $this->timeScale);


        return str_pad(
            substr(
                sprintf($this->format, $this->speed),
                -$this->getLength()
            ),
            $this->getLength(),
            $this->fillChar,
            $this->pad);


    }
}
