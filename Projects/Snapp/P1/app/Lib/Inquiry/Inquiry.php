<?php

namespace App\Lib\Inquiry;

use App\Exceptions\Inquiry\DriverNotFoundException;
use App\Lib\Inquiry\Contracts\InquiryInterface;

class Inquiry
{
    protected string $driver;

    protected array $settings;

    protected object $driverInstance;

    public function __construct(
        public array $config
    ) {
        $this->setDriver($this->config['default']);
    }

    public function setDriver(string $driver)
    {
        $this->driver = $driver;
        $this->validateDriver();
        $this->settings = $this->config['drivers'][$driver];

        return $this;
    }

    protected function getFreshDriverInstance()
    {
        $class = $this->config['map'][$this->driver];

        $this->driverInstance = new $class($this->settings);

        return $this->driverInstance;
    }

    protected function getDriverInstance()
    {
        if (! empty($this->driverInstance)) {
            return $this->driverInstance;
        }

        return $this->getFreshDriverInstance();
    }

    public function validateCardNumber(string $cardNumber)
    {
        $driverInstance = $this->getDriverInstance();
        try {
            return $driverInstance->validateCardNumber($cardNumber);
        } catch (\Throwable $th) {
            //
        }

        return false;
    }

    protected function validateDriver()
    {
        if (empty($this->driver)) {
            throw new DriverNotFoundException('Driver not selected or default driver does not exist.');
        }

        if (empty($this->config['drivers'][$this->driver]) || empty($this->config['map'][$this->driver])) {
            throw new DriverNotFoundException('Driver not found in config file.');
        }

        if (! class_exists($this->config['map'][$this->driver])) {
            throw new DriverNotFoundException('Driver source not found.');
        }

        $reflect = new \ReflectionClass($this->config['map'][$this->driver]);

        if (! $reflect->implementsInterface(InquiryInterface::class)) {
            throw new \Exception('Driver must be an instance of InquiryInterface.');
        }
    }
}
