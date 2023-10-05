<?php
namespace BergPlaza\MediaFile\Adapters\Video;

use wapmorgan\BinaryStream\BinaryStream;
use BergPlaza\MediaFile\Adapters\Containers\AsfAdapter;
use BergPlaza\MediaFile\Adapters\ContainerAdapter;
use BergPlaza\MediaFile\Adapters\VideoAdapter;

/**
 * WMV uses ASF as a container
 */
class WmvAdapter extends AsfAdapter implements VideoAdapter {
    protected $length;
    protected $width;
    protected $height;
    protected $framerate;

    /**
     * @throws \BergPlaza\MediaFile\Exceptions\ParsingException
     */
    protected function scan() {
        parent::scan();
        $this->length = $this->properties['send_length'];
        foreach ($this->streams as $stream) {
            if ($stream['type'] == ContainerAdapter::VIDEO && empty($this->width)) {
                $this->width = $stream['width'];
                $this->height = $stream['height'];
                $this->framerate = $stream['framerate'];
                break;
            }
        }
    }

    /**
     * @return int
     */
    public function getLength() {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getFrameRate() {
        return $this->framerate;
    }
}
