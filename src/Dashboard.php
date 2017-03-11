<?php

namespace Casadatos\Component\Dashboard;

use Casadatos\Component\Dashboard\Exception\DashboardException;
use Casadatos\Component\Dashboard\Gauge\Gauge;

abstract class Dashboard
{
    /**
     * An array of gauges
     *
     * @var Gauge[]
     */
    protected $gauges;
    protected $headers;

    public function add($gaugeName, Gauge $gauge) {
        $this->gauges[$gaugeName] = $gauge;

        return $this;
    }

    public function init() {
        foreach ($this->gauges as $gauge) {
            $gauge->init();
        }

        return $this;
    }

    public function summarize() {
        // does nothing so far, perhaps you should check other implementations
    }

    public function getGauge($gaugeName) {
        if (!$this->gauges[$gaugeName] instanceof Gauge) {
            throw new DashboardException('Gauge by name ' . $gaugeName . ' doesn\'t exist!');
        }
        return $this->gauges[$gaugeName];
    }

    public function update($gaugeName, $value) {

        $this->getGauge($gaugeName)->update($value);

        return $this;
    }

    public function getGaugesValues() {
        $arr = array();
        foreach ($this->gauges as $gaugeName => $gauge) {
            $arr[$gaugeName] = $gauge->refresh();
        }

        return $arr;
    }

    public function getHeaders() {
        $headers = array();
        foreach ($this->headers as $gaugeKey => $gaugeName) {
            $headers[$gaugeName] = str_pad($gaugeName, $this->gauges[$gaugeKey]->getLength(), " ", STR_PAD_BOTH);
        }
        return $headers;
    }

    public function printHeaders() {

        return $this;
    }

    public function __toString()
    {
        return $this->refresh();
    }

    /**
     * Should refresh dashboard state
     * @param bool $force parameters that should allow forced unconditional refresh
     * @return $this
     */
    abstract public function refresh($force=false);

    /**
     * Makes a snap of current dashboard state. Depends on Dashboard implementation
     * what it does exactly. On console it should just echo PHP_EOL.
     * @return $this
     */
    abstract public function snap();
}
