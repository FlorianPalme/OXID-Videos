<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Core;

use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;

class Video
{
    /**
     * url to video file
     *
     * @var string
     */
    protected $videoUrl;

    /**
     * Defines default attributes for video tag
     *
     * @var array
     */
    protected $defaultAttributes = [
        'autoplay' => false,
        'controls' => true,
        'loop' => false,
        'preload' => 'metadata', // (auto) | metadata | none
        'muted' => true,
        'width' => 0,
        'height' => 0,
        'poster' => false,
        'playsinline' => true,
    ];

    /**
     * Array mix of user defined and default attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Video constructor.
     *
     * @param string $fileName
     * @param array $attributes
     *
     * @throws StandardException
     */
    public function __construct(string $fileName = null, array $attributes = [])
    {
        if ($fileName) {
            /** @var UtilsVideo $utilsVideo */
            $utilsVideo = oxNew(UtilsVideo::class);
            $videoUrl = $utilsVideo->generateVideoUrl($fileName);
            $attributes['src'] = $videoUrl;
        }

        // load defaults
        $this->attributes = array_merge($this->defaultAttributes, $attributes);
    }

    /**
     * Return the video tag
     *
     * @return string
     * @throws StandardException
     */
    public function getEmbedCode(): string
    {
        $attributes = $this->getFilteredAttributes();

        return '<video ' . implode(' ', $attributes) . '></video>';
    }


    /**
     * Returns an array, that only includes video-parameters, that need to be integrated in html
     *
     * @return array
     * @throws StandardException
     */
    protected function getFilteredAttributes(): array
    {
        $attributes = [];

        // add video url
        if (array_key_exists('src', $this->attributes)) {
            $attributes[] = 'src="' . $this->attributes['src'] . '"';
        } else {
            /** @var StandardException $exception */
            $exception = oxNew(StandardException::class, 'Could not find a video', 465002);
            throw new $exception;
        }

        // should video be autoplayed?
        if (array_key_exists('autoplay', $this->attributes) && $this->attributes['autoplay'] === true) {
            $attributes[] = 'autoplay';
        }

        // any visible video controls?
        if (array_key_exists('controls', $this->attributes) && $this->attributes['controls'] === true) {
            $attributes[] = 'controls';
        }

        // loop the video
        if (array_key_exists('loop', $this->attributes) && $this->attributes['loop'] === true) {
            $attributes[] = 'loop';
        }

        // play video muted
        if (array_key_exists('muted', $this->attributes) && $this->attributes['muted'] === true) {
            $attributes[] = 'muted';
        }

        // display poster before video play
        if (array_key_exists('poster', $this->attributes) && $this->attributes['poster'] !== false) {
            $attributes[] = 'poster="' . $this->attributes['poster'] . '"';
        }

        // set video width
        if (array_key_exists('width', $this->attributes) && $this->attributes['width'] !== 0) {
            $attributes[] = 'width="' . $this->attributes['width'] . '"';
        }

        // set video height
        if (array_key_exists('height', $this->attributes) && $this->attributes['height'] !== 0) {
            $attributes[] = 'height="' . $this->attributes['height'] . '"';
        }

        // should video be preloaded?
        if (array_key_exists('preload', $this->attributes) && $this->attributes['preload'] !== 'auto') {
            if ($this->attributes['preload'] === 'metadata' || $this->attributes['preload'] === 'none') {
                $attributes[] = 'preload="' . $this->attributes['preload'] . '"';
            }
        }

        // play video inline
        if (array_key_exists('playsinline', $this->attributes) && $this->attributes['playsinline'] === true) {
            $attributes[] = 'playsinline';
        }

        return $attributes;
    }
}