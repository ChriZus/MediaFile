<?php
namespace BergPlaza\MediaFile\Adapters\Audio;

use BergPlaza\MediaFile\Adapters\AudioAdapter;
use BergPlaza\Mp3Info\Mp3Info;
use BergPlaza\MediaFile\Exceptions\FileAccessException;

class Mp3Adapter implements AudioAdapter {
    protected $filename;
    protected $mp3;

    /**
     * Mp3Adapter constructor.
     *
     * @param $filename
     *
     * @throws \BergPlaza\MediaFile\Exceptions\FileAccessException
     * @throws \Exception
     */
    public function __construct($filename) {
        if (!file_exists($filename) || !is_readable($filename)) throw new FileAccessException('File "'.$filename.'" is not available for reading!');
        $this->filename = $filename;
        $this->mp3 = new Mp3Info($filename);
    }

    /**
     * @return float|int
     */
    public function getLength() {
        return $this->mp3->duration;
    }

    /**
     * @return int
     */
    public function getBitRate() {
        return $this->mp3->bitRate;
    }

    /**
     * @return int
     */
    public function getSampleRate() {
        return $this->mp3->sampleRate;
    }

    /**
     * @return int
     */
    public function getChannels() {
        return $this->mp3->channel == 'mono' ? 1 : 2;
    }

    /**
     * @return bool
     */
    public function isVariableBitRate() {
        return $this->mp3->isVbr;
    }

    /**
     * @return bool
     */
    public function isLossless() {
        return false;
    }
}
