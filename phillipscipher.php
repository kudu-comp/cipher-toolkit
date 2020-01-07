<?php

class phillipscipher {
    
	// The Phillips cipher system was devised by the British during the First World War. It is based 
	// on a Polybius square whose rows, columns or both are reordered to form 8 different squares. 
	
	// The keyed alphabet is written into the matrix #1 horizontally and each row, or column, 
	// is numbered 1 to 5. Matrix #2 is formed from the first matrix by moving row 1 down a row, 
	// or column 1 to the right one place. The same row is moved down again to form matrices #3, #4 
	// and #5. Matrix #6 is formed by moving the top row, numbered 2, down a row and again for Matrices #7 
	// and #8. It should be noted that matrices #1 and #5 are the same as are matrices #2 and #8.
	
	// The plaintext is enciphered using each square in turn for groups of 5 letters.

    protected $size;        //Size of the square
    protected $squares;     //The polybius squares used
    protected $key;         //Key used to generate cipher alphabet
    protected $cipher;      //Keyed alphabet used in some polybius related ciphers
	protected $alphabet;
    
    public function __construct ($alphabet = "", $key = "") {
        $this->alphabet = $alphabet;
		$this->size = (int) ceil(sqrt (strlen($alphabet)));
		//parent::__construct ($alphabet, $rows . $cols);
        $this->cipher = $alphabet;
        $this->setkey ($key);
    }
    
	public function shufflealphabet ($alphabet, $key) {
	    return implode("", array_values (array_unique (str_split($key . $alphabet))));
	}
	
    public function setkey ($key) {
        $this->cipher = $this->shufflealphabet ($this->alphabet, $key);
        $this->key = $key;
        $this->setsquares ();
    }
    public function getkey () { return $this->key; }
    
    public function setsquares () {
        
        // Check square
        if (($this->size**2) != strlen($this->cipher)) { $this->squares = null; return; }
        $this->squares = array();
		$sz = $this->size;
		
        // Fill squares
        $this->squares[0] = $this->cipher;
		$this->squares[1] = substr($this->cipher, $sz,   $sz)   . substr($this->cipher, 0, $sz) . substr($this->cipher, 2*$sz);
		$this->squares[2] = substr($this->cipher, $sz,   2*$sz) . substr($this->cipher, 0, $sz) . substr($this->cipher, 3*$sz);
		$this->squares[3] = substr($this->cipher, $sz,   3*$sz) . substr($this->cipher, 0, $sz) . substr($this->cipher, 4*$sz);
		$this->squares[4] = substr($this->cipher, $sz,   4*$sz) . substr($this->cipher, 0, $sz);
		$this->squares[5] = substr($this->cipher, 2*$sz, $sz)   . substr($this->cipher, $sz, $sz) . 
							substr($this->cipher, 3*$sz, $sz)   . substr($this->cipher, 4*$sz, $sz) . substr($this->cipher, 0, $sz);
		$this->squares[6] = substr($this->cipher, 2*$sz, 2*$sz) . substr($this->cipher, $sz, $sz) . 
							substr($this->cipher, 4*$sz, $sz)   . substr($this->cipher, 0, $sz);
		$this->squares[7] = substr($this->cipher, 2*$sz, 3*$sz) . substr($this->cipher, $sz, $sz) . substr($this->cipher, 0, $sz);
    }
    
    public function encode ($msg) {
		
		$s = "";
		$sq = 0;
		$cnt = 0;
		for ($i = 0; $i <strlen($msg); $i++) {
			$pos = stripos ($this->squares[$sq], $msg[$i]);
			if ($pos !== FALSE) {
				$r = intdiv($pos, $this->size);
				$c = $pos % $this->size;
				($r == ($this->size - 1)) ? $r1 = 0 : $r1 = $r + 1;
				($c == ($this->size - 1)) ? $c1 = 0 : $c1 = $c + 1;
				$s .= $this->squares[$sq][$r1 * $this->size + $c1];
				$cnt++;
				if ($cnt == $this->size) { $sq++; $cnt = 0; }
				if ($sq == 8) $sq = 0;
			}
		}
		
        return $s;
    }
    
    public function decode ($msg) {
        // Decode
		
		$s = "";
		$sq = 0;
		$cnt = 0;
		for ($i = 0; $i <strlen($msg); $i++) {
			$pos = stripos ($this->squares[$sq], $msg[$i]);
			if ($pos !== FALSE) {
				$r = intdiv($pos, $this->size);
				$c = $pos % $this->size;
				($r == 0) ? $r1 = $this->size - 1 : $r1 = $r - 1;
				($c == 0) ? $c1 = $this->size - 1 : $c1 = $c - 1;
				$s .= $this->squares[$sq][$r1 * $this->size + $c1];
				$cnt++;
				if ($cnt == $this->size) { $sq++; $cnt = 0; }
				if ($sq == 8) $sq = 0;
			}
		}
		
        return $s;
    }
    
} // End of polybiuscipher

$c = new phillipscipher ("ABCDEFGHIKLMNOPQRSTUVWXYZ", "PATIENCE");

echo $c->encode ("The things that come to those who wait, may be the things left by those who got there first");
echo $c->decode("DRNDRMAQZLTRSKWOVYAYRWZNTBWTKMLOKEYGLRGLRFHQZUGPLIFSTWZVBRAQWDDRNYGOMYFL");

?>
