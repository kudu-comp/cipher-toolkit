<?php


class beaufortcipher extends vigenerecipher {

  public function settableau ($keyiterator="", $keycipher="", $keyplain="", $keycol="") {

          $this->keyiterator = $keyiterator;
          $this->iterkeylen  = strlen ($keyiterator);
          $this->keycipher   = $keycipher;
          $this->keyplain    = $keyplain;
          $this->keycol      = $keycol;

          // Create plainalphabet
          $this->plainalphabet = $this->shufflealphabet ($keyplain, $this->alphabet);

          // Create cipheralphabet
          $this->cipheralphabet = $this->shufflealphabet ($keycipher, $this->alphabet);

          // Create a tableau - each row contains a shifted alphabet
          $this->tableau = array();
          if ($keycol == "")
              $pos = 0;
          else {
              $pos = $this->strpos2($this->plainalphabet, $keycol);
              if ($pos === FALSE) $pos=0;
          }
          
          // The beaufort cipher uses a reversed alphabet as a tableau
          $s = strrev($this->cipheralphabet);
          for ($i=0; $i<strlen($this->cipheralphabet); $i++) {
              $this->tableau[$this->cipheralphabet[($i + $pos) % strlen($this->cipheralphabet) ]]= $s;
              $s = substr($s,1) . $s[0];
          }
      }
}

?>
