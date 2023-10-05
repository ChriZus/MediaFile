<?php
namespace BergPlaza\MediaFile\Adapters\Video;

use BergPlaza\MediaFile\Adapters\audio\Containers\MatroskaContainer;
use BergPlaza\MediaFile\Adapters\ContainerAdapter;
use BergPlaza\MediaFile\Adapters\VideoAdapter;

class MkvAdapter extends MatroskaContainer implements VideoAdapter, ContainerAdapter {

    /**
     * @return int
     */
    public function getLength() {
        return $this->duration;
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
