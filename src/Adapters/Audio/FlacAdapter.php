<?php
namespace BergPlaza\MediaFile\Adapters\Audio;

use Flac;
use BergPlaza\MediaFile\Adapters\AudioAdapter;
use BergPlaza\MediaFile\Exceptions\FileAccessException;

class FlacAdapter implements AudioAdapter {
    protected $filename;
    protected $flac;

    /**
     * FlacAdapter constructor.
     *
     * @param $filename
     *
     * @throws \ErrorException
     * @throws \BergPlaza\MediaFile\Exceptions\FileAccessException
     */
    public function __construct($filename) {
        if (!file_exists($filename) || !is_readable($filename)) throw new FileAccessException('File "'.$filename.'" is not available for reading!');
        $this->filename = $filename;
        $this->flac = new Flac($filename);
    }

    /**
     * @return int|null
     */
    public function getLength() {
        return $this->flac->streamDuration;
    }

    /**
     * @return float|int
     */
    public function getBitRate() {
        return floor($this->flac->streamBitsPerSample * $this->flac->streamTotalSamples / $this->flac->streamDuration);
    }

    /**
     * @return int|null
     */
    public function getSampleRate() {
        return $this->flac->streamSampleRate;
    }

    /**
     * @return int|null
     */
    public function getChannels() {
        return $this->flac->streamChannels;
    }

    /**
     * @return bool
     */
    public function isVariableBitRate() {
        return true;
    }

    /**
     * @return bool
     */
    public function isLossless() {
        return false;
    }
}
