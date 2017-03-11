<?php

namespace Casadatos\Component\Dashboard\Gauge;

abstract class Gauge
{
    private $value;
    private $length;

    public function __construct() {

    }

    public function init() {
        // does nothing by default

        return $this;
    }

    public function update($value) {
        $this->value = $value;

        return $this;
    }

    public function setLength($length) {
        $this->length = $length;

        return $this;
    }

    public function getLength() {
        return $this->length;
    }

    public function getValue() {
        return $this->value;
    }

    abstract public function refresh($force=false);
}
