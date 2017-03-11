<?php

namespace Casadatos\Component\Dashboard\Gauge;

class WorkingProgressBarGauge extends ProgressBarGauge
{
    private $length;
    protected $rotation = array ('|', '/', '-', '\\');
    protected $rotationIndex = 0;

    public function __construct($maxValue,  $overallLength=20, $decimalPlaces=2)
    {
        $this->length = $overallLength;

        parent::__construct($maxValue, $overallLength - 2, $decimalPlaces);
    }

    public function getLength()
    {
        return $this->length;
    }

    public function refresh($force=false)
    {
        if ($this->rotationIndex > 3) {
            $this->rotationIndex = 0;
        }

        return parent::refresh($force) . ' ' . $this->rotation[$this->rotationIndex++];
    }
}
