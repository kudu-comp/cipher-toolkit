<?php

namespace cipher;

class polybiuscipher extends cipher {

    protected $size;        //Size of the square
    protected $rows;        //Row headers
    protected $cols;        //Col headers
    protected $square;      //The polybius square
    protected $key;         //Key used to generate cipher alphabet
    protected $cipher;      //Keyed alphabet used in some polybius related ciphers

    public function __construct ($alphabet = UPPER_ALPHABET_REDUCED, $key = "", $rows="12345", $cols="12345") {
        parent::__construct ($alphabet, $rows . $cols);
        $this->size = strlen($rows);
        $this->setkey($key);
    }

    public function setkey ($key) {
        $this->cipher = $this->shufflealphabet ($this->alphabet, $key);
        $this->key = $key;
        $this->setsquare ($this->rows, $this->cols);
    }
    public function getkey () { return $this->key; }

    public function setsquare ($rows="12345", $cols="12345") {

        // Check square
        if (strlen($rows) != strlen($cols)) { $this->square = null; return; }
        if (($this->size**2) != strlen($this->cipher)) { $this->square = null; return; }

        // Fill square
        $this->rows = $rows;
        $this->cols = $cols;
        $this->setvalidcodes ($rows . $cols);
        $this->square = [];
        for ($r = 0; $r < $this->size; $r++)
            for ($c = 0; $c < $this->size; $c++)
                $this->square[$this->cipher[$r * $this->size + $c]] = $rows[$r] . $cols[$c];
    }

    public function encode ($msg) {
        // Encode message
        return $this->arraysubstitution ($msg, $this->square);
    }

    public function decode ($msg) {
        // Clean input including separators
        $msg = $this->cleanencodedmessage($msg, TRUE);
        $msgarr = [];
        for ($i=0; $i < strlen($msg); $i+=2) $msgarr[]=substr($msg, $i, 2);
        // Decode
        return $this->arraysubstitution ($msgarr, array_flip($this->square));
    }

} // End of polybiuscipher

?>
