<?php 

use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase
{
    private static $CI;

    public static function setUpBeforeClass(): void
    {
        self::$CI =& get_instance();
    }

    public function test_true(): void
    {
        $this->assertTrue(true);
    }
}