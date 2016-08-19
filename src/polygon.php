<?php namespace Polygon;

class Polygon
{
    /**
     * @var []
     */
    protected $points = [];

    /**
     * @var bool
     */
    protected $valid;

    /**
     * Polygon constructor.
     *
     * @param array|null $points
     */
    public function __construct(array $points = null)
    {
        if ($points) {
            $this->setPoints($points);
        } else {
            $this->valid = false;
        }
    }

    /**
     * @param array $points
     *
     * @return $this
     */
    public function setPoints(array $points)
    {
        $this->valid = false;
        if (count($points) >= 3) {
            $this->valid = true;
            foreach ($points as $point) {
                if (!$this->checkPoint($point)) {
                    $this->valid = false;

                    return $this;
                }
            }
        } else {
            return $this;
        }
        $this->points = $points;

        return $this;
    }

    /**
     * Contain all points of min rectangle points.
     *
     * @return array
     */
    public function rectanglePoints()
    {
        $lats = array_column($this->points, 0);
        $lngs = array_column($this->points, 1);
        $min_lat = min($lats);
        $min_lng = min($lngs);
        $max_lat = max($lats);
        $max_lng = max($lngs);

        return [[$min_lat, $min_lng], [$min_lat, $max_lng], [$max_lat, $max_lng], [$max_lat, $min_lng]];
    }

    /**
     * @return []
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @param double $lat
     * @param double $lng
     *
     * @return bool
     */
    public function contain($lat, $lng)
    {
        $count = 0;
        $points = $this->points;
        $points[] = reset($points);
        $point1 = reset($points);

        while ($point2 = next($points)) {
            $x1 = $point1[0];
            $y1 = $point1[1];
            $x2 = $point2[0];
            $y2 = $point2[1];
            if ($lat >= min($x1, $x2) && $lat <= max($x1, $x2) && $x1 != $x2) {
                $tmp = $y1 + ($lat - $x1) / ($x2 - $x1) * ($y2 - $y1);
                if ($tmp < $lng) {
                    $count++;
                } elseif ($tmp == $lng) {
                    //in line
                    return true;
                }
            }
            $point1 = $point2;
        }

        return $count % 2 === 1;
    }

    /**
     * @param $point
     *
     * @return bool
     */
    private function checkPoint($point)
    {
        return is_array($point) && count($point) == 2 && is_numeric($point[0]) && is_numeric($point[1]);
    }
}
