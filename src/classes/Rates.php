<?php

namespace Rates;

const GPS_SERVICE_NAME = 'GPS';
const GPR_PRICE = 15;
const DRIVER_SERVICE_NAME = 'Driver';
const DRIVER_PRICE = 100;
const MAIN_SERVICE_TEXT = 'Car rent';
const TOTAL_TEXT = 'Total';
const MINUTES_TO_HOURS_RATE = 60;

trait Gps {
    public function addGps(): void
    {
        $gpsRentTime = max($this->rentTime / MINUTES_TO_HOURS_RATE, 1);
        $gpsPrice = ceil(GPR_PRICE * $gpsRentTime);
        $this->priceTotal += $gpsPrice;
        $this->usedServices[] = GPS_SERVICE_NAME .': ' . $gpsPrice;
    }
}

trait Driver {
    public function addDriver(): void
    {
        $this->priceTotal += DRIVER_PRICE;
        $this->usedServices[] = DRIVER_SERVICE_NAME .': ' . DRIVER_PRICE;
    }
}

interface fRates {
    public function calculatePrice(int $time, int $distance = 0);
    public function getReceipt();
}

abstract class Rates implements fRates
{
    protected $pricePerKm;
    protected $pricePerMin;
    protected $rentTime;
    protected $priceTotal = 0;
    protected $usedServices = [];

    private function __constructor(): void
    {
    }

    protected function setInitials($pricePerKm, $pricePerMin): void
    {
        $this->pricePerKm = $pricePerKm;
        $this->pricePerMin = $pricePerMin;
    }

    public function getReceipt(): string
    {
        $this->usedServices[] = TOTAL_TEXT . ': ' . $this->priceTotal;
        return implode('<br/>', $this->usedServices);
    }

}

class Student extends Rates
{
    private static Student $instance;
    protected $pricePerKm  = 4;
    protected $pricePerMin = 1;
    protected $usedServices = [__CLASS__];

    use Gps;

    use Driver;

    private function __constructor(): void
    {
        parent::setInitials($this->pricePerKm, $this->pricePerMin);
    }

    static function initialize(): object
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /*time - minutes, distance - km*/
    public function calculatePrice(int $time, int $distance = 0): void
    {
        $this->rentTime = $time;
        $priceTotal = $this->pricePerKm * $distance + $this->pricePerMin * $time;
        $this->priceTotal =  $priceTotal;
        $this->usedServices[] = MAIN_SERVICE_TEXT .': ' . $priceTotal;
    }
}

class Basic extends Rates
{
    private static Basic $instance;
    protected $pricePerKm  = 10;
    protected $pricePerMin = 3;
    protected $usedServices = [__CLASS__];

    use Gps;

    use Driver;

    private function __constructor(): void
    {
        parent::setInitials($this->pricePerKm, $this->pricePerMin);
    }

    static function initialize(): object
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /*time - minutes, distance - km*/
    public function calculatePrice(int $time, int $distance = 0): void
    {
        $this->rentTime = $time;
        $priceTotal = $this->pricePerKm * $distance + $this->pricePerMin * $time;
        $this->priceTotal =  $priceTotal;
        $this->usedServices[] = MAIN_SERVICE_TEXT .': ' . $priceTotal;
    }
}

class Hours extends Rates
{
    private static Hours $instance;
    protected $pricePerKm  = 0;
    protected $pricePer60Min = 200;
    protected $usedServices = [__CLASS__];

    use Gps;

    use Driver;

    private function __constructor(): void
    {
    }

    static function initialize(): object
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /*time - minutes, distance - km*/
    public function calculatePrice(int $time, int $distance = 0): void
    {
        $this->rentTime = $time;
        $time = max($time, MINUTES_TO_HOURS_RATE) / MINUTES_TO_HOURS_RATE;
        $priceTotal = $this->pricePerKm * $distance + $this->pricePer60Min * $time;
        $this->priceTotal =  $priceTotal;
        $this->usedServices[] = MAIN_SERVICE_TEXT .': ' . $priceTotal;
    }
}
