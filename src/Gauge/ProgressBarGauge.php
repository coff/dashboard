<?php

namespace Casadatos\Component\Dashboard\Gauge;

use Casadatos\Common\Exception\CasadatosException;

class ProgressBarGauge extends Gauge
{
    protected $voidChar=' ';
    protected $fillChar='#';
    protected $maxValue;
    private $length;
    protected $decimalPlaces;
    protected $labelLength;
    protected $barLength;
    protected $format;

    public function __construct($maxValue, $overallLength=20, $decimalPlaces=2)
    {
        $this->length = $overallLength;
        $this->decimalPlaces  = $decimalPlaces;

        $this->labelLength = 3 + ($this->decimalPlaces > 0 ? 1 : 0) + $this->decimalPlaces + 1;
        $this->barLength = $this->length - $this->labelLength - 1;
        $this->maxValue = $maxValue;

        if ($this->maxValue == 0) {
            throw new CasadatosException('maxValue must be other than 0');
        }

        if ($this->decimalPlaces > 0) {
            $this->format = "%" .($this->decimalPlaces + 1 + 3) . "." . $this->decimalPlaces . "f";
        } else {
            $this->format = "%3d";
        }

        parent::__construct();
    }

    public function getLength()
    {
        return $this->length;
    }

    public function refresh($force=false) {
        $rel = $this->getValue() / $this->maxValue;

        if ($rel > 1) {
            $rel = 1;
        }

        $fillChars = $rel * $this->barLength;
        $bar = str_pad(str_pad("", $fillChars, $this->fillChar, STR_PAD_LEFT), $this->barLength, $this->voidChar, STR_PAD_RIGHT);
        return $bar . ' ' . sprintf($this->format, $rel * 100) . '%';
    }
}
