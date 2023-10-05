<?php
use BergPlaza\MediaFile\MediaFile;

class AacAudioTest extends PHPUnit_Framework_TestCase
{
	public function testAudio1()
	{
		$file = MediaFile::open(FIXTURES_DIR.'/audio/audio_1.aac');
		$this->assertInstanceOf('BergPlaza\MediaFile\MediaFile', $file);
		$this->assertTrue($file->isAudio());

        // checking audio interfac
        $audio = $file->getAudio();
		$this->assertInstanceOf('BergPlaza\MediaFile\Adapters\AudioAdapter', $audio);
		$this->assertEquals(34, $audio->getLength(), '', 2);
		$this->assertEquals(44100, $audio->getSampleRate());
		$this->assertEquals(2, $audio->getChannels());
	}
}
