<?php
namespace SerialImprovement\Core;

class Input
{
    protected $vars;

    public function __construct(array $vars = [])
    {
        $this->vars = $vars;
    }

    /**
     * @param string $name
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get(string $name, $default = null)
    {
        if (!$this->has($name)) {
            return $default;
        }

        return $this->vars[$name];
    }

    public function __get(string $name)
    {
        return $this->get($name);
    }

    public function set(string $name, $value)
    {
        $this->vars[$name] = $value;
    }

    public function __set(string $name, $value)
    {
        $this->set($name, $value);
    }

    public function remove(string $name)
    {
        unset($this->vars[$name]);
    }

    public function has(string $name): bool
    {
        return isset($this->vars[$name]);
    }

    /**
     * Extracts the given keys into a new Input object
     *
     * @param array $keys
     * @return Input
     */
    public function extract(array $keys): Input
    {
        $input = new self();

        foreach ($keys as $key) {
            $input->set($key, $this->get($key));
        }

        return $input;
    }

    public function toArray(): array
    {
        return $this->vars;
    }

    /**
     * @deprecated just use the constructor now `new Input(['foo' => 'bar'])`
     */
    public static function buildFromHash(array $hash): Input
    {
        $input = new Input();

        foreach ($hash as $key => $value) {
            $input->set($key, $value);
        }

        return $input;
    }
}
