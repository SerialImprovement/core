<?php
namespace SerialImprovement\Core;

class InputTest extends \PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $input = new Input();
        $input->set('banana', 'man');

        $this->assertTrue($input->has('banana'));
        $this->assertSame('man', $input->get('banana'));
    }

    public function testRemove()
    {
        $input = Input::buildFromHash([
            'banana' => 'man'
        ]);
        $input->remove('banana');

        $this->assertFalse($input->has('banana'));
    }

    public function testGetNotExists()
    {
        $input = new Input();
        $this->assertNull($input->get('key_does_not_exist'));
    }

    public function testGetNotExistsWithDefault()
    {
        $input = new Input();
        $this->assertEquals('teapot', $input->get('key_does_not_exist_but_has_default', 'teapot'));
    }

    public function testGetGetsRealValueInsteadOfDefault()
    {
        $input =  Input::buildFromHash([
            'banana' => 'man'
        ]);
        $this->assertEquals('man', $input->get('banana', 'teapot'));
    }

    public function testFromHash()
    {
        $input = Input::buildFromHash([
            'banana' => 'man'
        ]);

        $this->assertTrue($input->has('banana'));
        $this->assertSame('man', $input->get('banana'));
    }

    public function testExtract()
    {
        $input = Input::buildFromHash([
            'banana' => 'man',
            'user' => [
                'name' => 'jim'
            ],
            'loggedIn' => true
        ]);

        $new = $input->extract(['user', 'loggedIn']);

        $this->assertCount(2, $new->toArray());
        $this->assertFalse($new->has('banana'));
        $this->assertTrue($new->has('user'));
        $this->assertTrue($new->has('loggedIn'));
    }
}
