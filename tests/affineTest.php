<?php

use PHPUnit\Framework\TestCase;
use cipher\affinecipher;

//All test files must be named *Test.php (case sensitive T)

class CaesarTest extends TestCase
{
    public function testCaesar()
    {
        // Test affine
        $c = new affinecipher(UPPER_ALPHABET, 5, 5);
        $res = $c->encode ("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG");
        $this->assertEquals("WOZHBTPDKMXLSEXQYBNCRXGZMWOZIFAVUXJ",$res, "Error encoding affine");
        $res = $c->decode ($res);
        $this->assertEquals("THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG",$res, "Error decoding caesar");
        
    }
}
?>
