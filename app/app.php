<?php

require_once __DIR__.'/../settings.php';
require_once __DIR__.'/character.php';

class App {

    // Characters in pixels
    protected $characters;

    // Date when the script starts
    protected $startingPoint;

    // Today
    protected $today;

    // Message to print
    protected $message;

    // In pixels format
    protected $pixels;

    public function initialize() {

        $character = new Character();
        $this->characters = $character->getCharacters();
        $this->startingPoint = STARTING_POINT;
        $this->today = date('Y-m-d',time());
        $this->message = PANEL_MESSAGE;
        $this->pixels = $this->messageToPixels($this->message);

    }

    public function run() {

        $this->initialize();

        if ($this->isPaintingDay()) {
            $this->paintPixel();
        }

    }

    public function isPaintingDay() {

        // The script will work just after the starting point
        if (strtotime($this->startingPoint)>strtotime($this->today)) {
            return false;
        }

        $diffDays = $this->_getDiffDates($this->startingPoint,$this->today);
        if ((int)$this->pixels[(int)$diffDays]==1) {
            return true;
        } else {
            return false;
        }

    }

    // Paint a pixel on green - by committing ~20 times
    public function paintPixel() {

        echo "paint!";

    }

    private function messageToPixels() {

        $charactersMessage = preg_split('//u', $this->message, -1, PREG_SPLIT_NO_EMPTY);
        $pixels = "";

        foreach ($charactersMessage as $character) {

            $array = $this->characters[$character];

            foreach ($array as $element) {
                $pixels .= $element;
            }

        }

        $pixelsChunked = chunk_split($pixels,7);
        print_r($pixelsChunked);

        return $pixels;

    }

    private function _getDiffDates($date1,$date2) {

        $dStart = new DateTime($date1);
        $dEnd  = new DateTime($date2);
        $dDiff = $dStart->diff($dEnd);

        return $dDiff->days;
    }

    // For testing purposes
    public function setToday($today) {
        $this->today = $today;
    }

}