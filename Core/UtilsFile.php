<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Core;


class UtilsFile extends UtilsFile_parent
{

    /**
     * Video savepath, realtiveto source/out/pictures
     *
     * @var string
     */
    protected $fpOXIDVideosSavePath = '../videos/';

    /**
     * List of allowed fileformats
     *
     * @var array
     */
    protected $fpOXIDVideosAllowedVideoFileFormats = ['mp4', 'webm', 'ogg'];

    /**
     * A backup of the default $_aAllowedFiles array
     *
     * @var array
     */
    protected $fpOXIDVideosDefaultFileFormatsBackup;

    /**
     * Allows upload of video files
     */
    public function fpOXIDVideosAllowVideoUpload()
    {
        $this->_aTypeToPath['FPOXIDVIDEOS'] = $this->fpOXIDVideosSavePath;
        $this->fpOXIDVideosDefaultFileFormatsBackup = $this->_aAllowedFiles;
        $this->_aAllowedFiles = array_merge($this->_aAllowedFiles, $this->fpOXIDVideosAllowedVideoFileFormats);
    }

    /**
     * Disallows upload of video files
     */
    public function fpOXIDVideosDisallowVideoUpload()
    {
        unset($this->_aTypeToPath['FPOXIDVIDEOS']);
        $this->_aAllowedFiles = $this->fpOXIDVideosDefaultFileFormatsBackup;
    }
}