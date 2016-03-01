# Casadatos Dashboard Component

Component for creating dashboards of gauges that let you know if your code 
runs smoothly.

```php

    /* Need it on dev only? No problem! */
    if ($isDev) 
        $this->dashboard = new ConsoleDashboard();
    else
        $this->dashboard = new NullDashboard();
    
    /* adding gauges */
    $this->dashboard
        ->add('houses', new ValueGauge($length=6))
        ->add('progress', new ProgressBarGauge($maxHauses=18000, $length=30,null,0))
        ->add('json size', new ByteGauge($length=12))
        ->add('loop memory', new DeltaMemoryGauge())
        ->add('loop time', new TimeGauge());
        
    /* some gauges are fed automatically with data some not */
    
    $this->dashboard
        ->init(); // starts timers and zeroes stuff

    while ($working) { 
        /* some loop in your code which you'd like to know how it performs
           its tasks */
        
        // ... some tasks here
           
        $this->dashboard
            ->update('progress', count($this->housesArr))
            ->update('houses', count($this->housesArr))
            ->update('json size', $size);
        
        $this->refresh();
        
        /* So far it refreshes on each loop iteration. Any idea how to control
           that? Let me know. Thought of making possible to be refreshed on 
           some events and on specific time intervals like (X times per sec./
           minute or whatever).
           
           So far you can only do it manually in your code.
           */
    }
    
    /* ... and finally let's close */
    $this->dashboard->summarize();
    
```

Preceding code produces following dashboard in realtime (while working):

```

+------+------------------------------+------------+------------+------------+
|houses|           progress           | json size  |loop memory | loop time  |
+------+------------------------------+------------+------------+------------+
| 18489|######################### 100%|   5381.73KB|      7.29MB|  0h 00m 54s|
+------+------------------------------+------------+------------+------------+

```
