<?php
namespace wapmorgan\MediaFile;

use Exception;
use wapmorgan\Mp3Info\Mp3Info;

class Mp3Adapter implements AudioAdapter {
    protected $filename;
    protected $mp3;

    static protected $channelModes = array(
        1 => self::MONO,
        2 => self::STEREO,
        3 => self::TRIPLE,
        4 => self::QUADRO,
        5 => self::FIVE,
        6 => self::SIX,
        7 => self::SEVEN,
        8 => self::EIGHT,
    );

    public function __construct($filename) {
        if (!file_exists($filename) || !is_readable($filename)) throw new Exception('File "'.$filename.'" is not available for reading!');
        $this->filename = $filename;
        $this->mp3 = new Mp3Info($filename);
    }

    public function getLength() {
        return $this->mp3->duration;
    }

    public function getBitRate() {
        return $this->mp3->bitRate;
    }

    public function getSampleRate() {
        return $this->mp3->sampleRate;
    }

    public function getChannels() {
        return $this->mp3->channel == 'mono' : 1 : 2;
    }

    public function isVariableBitRate() {
        return $this->mp3->isVbr;
    }

    public function isLossless() {
        return false;
    }
}
