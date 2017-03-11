<?php

namespace Casadatos\Component\Dashboard\Gauge;

class StopWatchGauge extends Gauge
{
    protected $startTime;
    protected $format;
    protected $fillChar = ' ';
    protected $pad;

    protected $isResetable = true;

    public function __construct($length = 13, $format = "%hh %Im %Ss", $pad = STR_PAD_LEFT)
    {
        $this->setLength($length);
        $this->format = $format;
        $this->pad = $pad;
    }

    public function setIsResetable($isResetable=true) {
        $this->isResetable = $isResetable;
    }

    public function init() {
        if ($this->isResetable || !$this->startTime instanceof \DateTime) {
            $this->startTime = new \DateTime();
            $this->update(new \DateInterval('PT0S'));
        }
    }

    public function refresh($force=false)
    {
        $time = new \DateTime();

        $this->update($time->diff($this->startTime));

        /** @var \DateInterval $val */
        $val = $this->getValue();

        return str_pad(
            substr(
                $val->format($this->format),
                0,
                $this->getLength()
            ),
            $this->getLength(),
            $this->fillChar,
            $this->pad);
    }
}
