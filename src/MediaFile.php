<?php
namespace BergPlaza\MediaFile;

use BergPlaza\FileTypeDetector\Detector;
use BergPlaza\MediaFile\Adapters\Audio\AacAdapter;
use BergPlaza\MediaFile\Adapters\Audio\AmrAdapter;
use BergPlaza\MediaFile\Adapters\Audio\FlacAdapter;
use BergPlaza\MediaFile\Adapters\Audio\Mp3Adapter;
use BergPlaza\MediaFile\Adapters\Audio\OggAdapter;
use BergPlaza\MediaFile\Adapters\Audio\WavAdapter;
use BergPlaza\MediaFile\Adapters\Audio\WmaAdapter;
use BergPlaza\MediaFile\Adapters\AudioAdapter;
use BergPlaza\MediaFile\Adapters\ContainerAdapter;
use BergPlaza\MediaFile\Adapters\Containers\AsfAdapter;
use BergPlaza\MediaFile\Adapters\Video\AviAdapter;
use BergPlaza\MediaFile\Adapters\Video\MkvAdapter;
use BergPlaza\MediaFile\Adapters\Video\Mp4Adapter;
use BergPlaza\MediaFile\Adapters\Video\WmvAdapter;
use BergPlaza\MediaFile\Adapters\VideoAdapter;
use BergPlaza\MediaFile\Exceptions\FileAccessException;

class MediaFile {
    const AUDIO = 'audio';
    const VIDEO = 'video';

    static protected $formatHandlers = [
        Detector::WAV => WavAdapter::class,
        Detector::MP3 => Mp3Adapter::class,
        Detector::FLAC => FlacAdapter::class,
        Detector::AAC => AacAdapter::class,
        Detector::OGG => OggAdapter::class,
        Detector::AMR => AmrAdapter::class,
        Detector::WMA => WmaAdapter::class,
        Detector::AVI => AviAdapter::class,
        Detector::ASF => AsfAdapter::class,
        Detector::WMV => WmvAdapter::class,
        Detector::MP4 => Mp4Adapter::class,
        Detector::MKV => MkvAdapter::class,
    ];

    /** @var string */
    protected $filename;
    protected $type;

    /** @var string */
    protected $format;

    /** @var AudioAdapter|VideoAdapter */
    public $adapter;

    /**
     * @param string $filename
     * @return MediaFile
     * @throws FileAccessException
     */
    static public function open($filename)
    {
        if (!file_exists($filename) || !is_readable($filename))
            throw new FileAccessException('File "'.$filename.'" is not available for reading!');

        $type = Detector::detectByFilename($filename) ?: Detector::detectByContent($filename);

        if ($type === false)
            throw new FileAccessException('Unknown format for file "'.$filename.'"!');

        if (!isset(self::$formatHandlers[$type[1]]))
            throw new FileAccessException('File "'.$filename.'" is not supported, it\'s "'.$type[0].'/'.$type[1].'"!');

        return new self($filename, $type[1]);
    }

    /**
     * MediaFile constructor.
     *
     * @param string $filename
     * @param string $format
     * @throws FileAccessException
     */
    public function __construct($filename, $format) {
        if (!file_exists($filename) || !is_readable($filename)) throw new Exceptions\FileAccessException('File "'.$filename.'" is not available for reading!');

        if (!isset(self::$formatHandlers[$format]))
            throw new FileAccessException('Format "'.$format.'" does not have a handler!');

        $adapter_class = self::$formatHandlers[$format];
        $this->adapter = new $adapter_class($filename);

        $this->filename = $filename;
        $this->format = $format;
    }

    /**
     * @return bool
     */
    public function isAudio() {
        return $this->adapter instanceof AudioAdapter;
    }

    /**
     * @return bool
     */
    public function isVideo() {
        return $this->adapter instanceof VideoAdapter;
    }

    /**
     * @return bool
     */
    public function isContainer() {
        return $this->adapter instanceof ContainerAdapter;
    }

    /**
     * @return string
     */
    public function getFormat() {
        return $this->format;
    }

    /**
     * @return AudioAdapter
     */
    public function getAudio() {
        return $this->adapter;
    }

    /**
     * @return VideoAdapter
     * @throws FileAccessException
     */
    public function getVideo() {
        return $this->adapter;
    }
}
