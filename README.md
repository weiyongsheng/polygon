Polygon
==========

Point in polygon

Usage
-----

```php
$polygon = new \Polygon\Polygon([
    [0, 0],
    [0, 1],
    [1, 1],
    [1, 0],
]);
var_dump($polygon->contain(0.5, 0.5)); // return bool(true)
```
