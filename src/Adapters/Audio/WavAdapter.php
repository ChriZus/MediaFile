<?php
namespace BergPlaza\MediaFile\Adapters\Audio;

use BoyHagemann\Wave\Wave;
use BergPlaza\MediaFile\Adapters\AudioAdapter;
use BergPlaza\MediaFile\Exceptions\FileAccessException;

class WavAdapter implements AudioAdapter {
    protected $filename;
    protected $wav;
    protected $metadata;

    /**
     * WavAdapter constructor.
     *
     * @param $filename
     *
     * @throws \BergPlaza\MediaFile\Exceptions\FileAccessException
     */
    public function __construct($filename) {
        if (!file_exists($filename) || !is_readable($filename)) throw new FileAccessException('File "'.$filename.'" is not available for reading!');
        $this->filename = $filename;
        $this->wav = new Wave();
        $this->wav->setFilename($filename);
        $this->metadata = $this->wav->getMetadata();
    }

    /**
     * @return \BoyHagemann\Wave\Chunk\Fmt
     */
    public function getMetadata() {
        return $this->metadata;
    }

    /**
     * @return float|int
     */
    public function getLength() {
        $bytesPerSecond = $this->metadata->getBytesPerSecond();
        return (filesize($this->filename) - 44) / $bytesPerSecond;
    }

    /**
     * @return float|int
     */
    public function getBitRate() {
        return floor($this->metadata->getBytesPerSecond() / 1000) * 1000;
    }

    /**
     * @return int
     */
    public function getSampleRate() {
        return $this->metadata->getSampleRate();
    }

    /**
     * @return int
     */
    public function getChannels() {
        return $this->metadata->getChannels();
    }

    /**
     * @return bool
     */
    public function isVariableBitRate() {
        return false;
    }

    /**
     * @return bool
     */
    public function isLossless() {
        return false;
    }
}
