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

    /**
     * @expectedException \RuntimeException
     */
    public function testGetNotExists()
    {
        $input = new Input();
        $input->get('key_does_not_exist');
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
