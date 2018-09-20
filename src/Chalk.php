<?php

namespace Dutymess\Chalk;


use Carbon\Carbon;

class Chalk
{
    const CACHE_KEY = "CHALK";
    /**
     * keep the expiry time of the catches
     *
     * @var int
     */
    protected static $expiry_time = 10;
    /**
     * keep the stack name in which the records are kept under
     *
     * @var string
     */
    protected $stack;



    /**
     * Chalk constructor
     *
     * @param string $stack_name
     */
    public function __construct($stack_name = 'default')
    {
        $this->stack = $stack_name;
    }



    /**
     * set cache timeout
     *
     * @param int $minutes
     */
    public static function setTimeout(int $minutes)
    {
        static::$expiry_time = $minutes;
    }



    /**
     * read the chalk stack
     *
     * @return array
     */
    public function read()
    {
        $stack_name = $this->stack;

        if (isset($this->getChalkCache()[$stack_name])) {
            return $this->getChalkCache()[$stack_name];
        }

        return [];
    }



    /**
     * write on the chalk stack
     *
     * @param mixed $thing
     * @param mixed $details
     *
     * @return array
     */
    public function write($thing, $details = null)
    {
        $data     = $this->getChalkCache();
        $incoming = $this->makeIncomingData($thing, $details);

        $data[$this->stack][] = $incoming;
        $this->setChalkCache($data);

        return $this->read();
    }



    /**
     * write on the chalk stack
     *
     * @deprecated
     *
     * @param mixed $thing
     * @param mixed $details
     *
     * @return array
     */
    public function add($thing, $details = null)
    {
        return $this->write($thing, $details);
    }



    /**
     * clear the chalk stack
     *
     * @return array
     */
    public function clear()
    {
        $data = $this->getChalkCache();
        unset($data[$this->stack]);

        $this->setChalkCache($data);

        return $this->read();
    }



    /**
     * clear all the chalk stacks
     *
     * @return array
     */
    public function clearAllStacks()
    {
        $this->setChalkCache([]);

        return $this->read();
    }



    /**
     * make a standard array to be added to the chalk cache
     *
     * @param mixed $thing
     * @param mixed $details
     *
     * @return array
     */
    private function makeIncomingData($thing, $details)
    {
        $array = [
             "timestamp" => Carbon::now()->toDateTimeString(),
             "thing"     => $thing,
        ];

        if (isset($details)) {
            $array['details'] = $details;
        }

        return $array;
    }



    /**
     * get chalk array in whole
     *
     * @return array
     */
    private function getChalkCache(): array
    {
        $data = cache()->get(static::CACHE_KEY);

        if (!$data or !is_array($data)) {
            return [];
        }

        return $data;
    }



    /**
     * set chalk array in whole
     *
     * @param array $data
     *
     * @return void
     */
    private function setChalkCache($data = [])
    {
        if ($this->shouldWork()) {
            cache()->put(static::CACHE_KEY, $data, static::$expiry_time);
        }
    }



    /**
     * determine if the chalk system should work
     *
     * @return bool
     */
    private function shouldWork(): bool
    {
        return config('app.debug');
    }
}
