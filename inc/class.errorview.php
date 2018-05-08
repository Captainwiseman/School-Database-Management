<?php

class ErrorView extends View {
    
    private $error;
    private $production = false;

    function __construct($e) {
        parent::__construct("Error");
        $this->error = $e;
        $this->dump();
    }

    public function dump() {
        require "components/htmltop.php";
        echo <<<HTM
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">        
                <h2 class="glyphicon glyphicon-exclamation-sign"></h2>
                <h3>Oooopsi, we had a little booboo....</h3>
                <h4>A message was sent to administrator</h4>
            </div>
HTM;
        $this->debug();
        echo '</div></div></div>';
        require "components/htmlbottom.php";
        die;
    }

    private function debug() {
        if(!$this->production) {
            echo '<pre>';
            $e = [];
            if(isset($this->error['message'])) {
                $e[] = $this->error['message'];
            }
            if(isset($this->error['code'])) {
                $e[] = "Code: {$this->error['code']}";
            }
            if(count($e)) {
                echo "<p>".implode($e,'<br>').'</p><hr>';
            }                
            print_r(debug_backtrace());
            echo '</pre>';
        }

    }
}