<?php

namespace Casadatos\Component\Dashboard;

class NullDashboard extends Dashboard
{
    public function printHeaders()
    {
        // does nothing

        return $this;
    }


    public function summarize()
    {
        // does nothing

        return $this;
    }

    public function refresh($force=false)
    {
        // does nothing

        return $this;
    }

    public function snap()
    {
        // does nothing

        return $this;
    }
}
