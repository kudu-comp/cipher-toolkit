<?php

use PHPUnit\Framework\TestCase;
use cipher\nihilisttranspositioncipher;
use const \cipher\UPPER_ALPHABET;

class NihilisttranspositionTest extends TestCase
{
    public function testNihilisttransposition()
    {
        // Test caesar
        $pt = "THEQUICKBROWNFOXJUMPSOVERTHELAZYDOGA";
        $ky = "213645";
        $ct = "KCBOWRHTEUIQFNOJUXTRHLAEYZDGAOPMSVEO";
        $c = new nihilisttranspositioncipher(UPPER_ALPHABET, $ky);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding nihilisttranspositioncipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding nihilisttranspositioncipher");
        
        // Test but with printing col after col
        $c->setreadrow (FALSE);
        $res = $c->encode ($pt);
        $this->assertEquals($ct,$res, "Error encoding nihilisttranspositioncipher");
        $res = $c->decode ($ct);
        $this->assertEquals($pt,$res, "Error decoding nihilisttranspositioncipher");
    }
}

?>
