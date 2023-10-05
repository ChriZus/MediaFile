<?php
namespace BergPlaza\MediaFile\Adapters\Video;

use BergPlaza\MediaFile\Adapters\Containers\Mpeg4Part12Adapter;
use BergPlaza\MediaFile\Adapters\ContainerAdapter;
use BergPlaza\MediaFile\Adapters\VideoAdapter;

class Mp4Adapter extends Mpeg4Part12Adapter implements VideoAdapter, ContainerAdapter {

    /**
     * @return float|int
     */
    public function getLength() {
        return $this->mvhd['duration'] / $this->mvhd['timescale'];
    }

    /**
     * @return int
     */
    public function getWidth() {
        foreach ($this->streams as $stream) {
            if ($stream['type'] == ContainerAdapter::VIDEO)
                return $stream['width'];
        }
    }

    /**
     * @return int
     */
    public function getHeight() {
        foreach ($this->streams as $stream) {
            if ($stream['type'] == ContainerAdapter::VIDEO)
                return $stream['height'];
        }
    }

    /**
     * @return int
     */
    public function getFrameRate() {
        foreach ($this->streams as $stream) {
            if ($stream['type'] == ContainerAdapter::VIDEO)
                return $stream['framerate'];
        }
    }

    /**
     * @return int
     */
    public function countStreams() {
        return count($this->streams);
    }

    /**
     * @return int
     */
    public function countVideoStreams() {
        $count = 0;
        foreach ($this->streams as $stream)
            if ($stream['type'] == ContainerAdapter::VIDEO) $count++;
        return $count;
    }

    /**
     * @return int
     */
    public function countAudioStreams() {
        $count = 0;
        foreach ($this->streams as $stream)
            if ($stream['type'] == ContainerAdapter::AUDIO) $count++;
        return $count;
    }

    /**
     * @return array
     */
    public function getStreams() {
        return $this->streams;
    }
}
