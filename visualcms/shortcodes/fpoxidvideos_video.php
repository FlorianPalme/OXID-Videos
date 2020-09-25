<?php

use FlorianPalme\OXIDVideos\Core\Video;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\VisualCmsModule\Application\Model\Media;
use OxidEsales\VisualCmsModule\Application\Model\VisualEditorShortcode;

/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

class fpoxidvideos_video_shortcode extends VisualEditorShortcode
{
    protected $_sTitle = 'FPOXIDVIDEOS_SHORTCODE_TITLE';
    protected $_sBackgroundColor = '#d35400';
    protected $_sIcon = 'fa-film';

    /**
     * Sets shortcode options
     */
    public function install()
    {
        $this->setShortCode( basename( __FILE__, '.php' ) );

        $lang = Registry::getLang();

        $this->setOptions([
           'video' => [
               'type' => 'file',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_UPLOAD'),
               'preview' => true,
           ],

           'autoplay' => [
               'type' => 'checkbox',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_AUTOPLAY'),
           ],

           'controls' => [
               'type' => 'checkbox',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_CONTROLS'),
               'default' => true,
           ],

           'loop' => [
               'type' => 'checkbox',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_LOOP'),
           ],

           'muted' => [
               'type' => 'checkbox',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_MUTED'),
               'default' => true,
           ],

           'width' => [
               'type' => 'text',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_WIDTH'),
               'default' => 0,
           ],

           'height' => [
               'type' => 'text',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_HEIGHT'),
               'default' => 0,
           ],

           'preload' => [
               'type' => 'select',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_PRELOAD'),
               'values' => [
                    'auto' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_PRELOAD_AUTO'),
                    'metadata' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_PRELOAD_METADATA'),
                    'none' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_PRELOAD_NONE'),
               ],
               'default' => 'metadata',
           ],

           'poster' => [
               'type' => 'image',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_POSTER'),
           ],

           'playsinline' => [
               'type' => 'checkbox',
               'label' => $lang->translateString('FPOXIDVIDEOS_SHORTCODE_PLAYSINLINE'),
               'default' => true,
           ],
        ]);
    }

    /**
     * @param string $sContent
     * @param array  $aParams
     *
     * @return string
     */
    public function parse($sContent = '', $aParams = []): string
    {
        try {
            $videoData = $aParams;
            $videoFile = $videoData['video'];

            unset($videoData['class']);
            unset($videoData['video']);
            $videoData['autoplay'] = (bool) $videoData['autoplay'];
            $videoData['controls'] = (bool) $videoData['controls'];
            $videoData['loop'] = (bool) $videoData['loop'];
            $videoData['muted'] = (bool) $videoData['muted'];
            $videoData['width'] = (int) $videoData['width'];
            $videoData['height'] = (int) $videoData['height'];
            $videoData['playsinline'] = (bool) $videoData['playsinline'];

            /** @var Media $media */
            $media = oxNew(Media::class);
            $videoData['src'] = $media->getMediaUrl($videoFile);

            if ($videoData['poster']) {
                $videoData['poster'] = $media->getMediaUrl($videoData['poster']);
            }

            /** @var Video $video */
            $video = oxNew(Video::class, null, $videoData);

            $smarty = Registry::getUtilsView()->getSmarty();
            $smarty->assign(
                [
                    'oView'     => $this->getConfig()->getTopActiveView(),
                    'shortcode' => $this->getShortCode(),
                    'videoEmbedCode' => $video->getEmbedCode(),
                    'class' => $aParams['class'],
                ]
            );

            return $smarty->fetch( 'fp/oxidvideos/shortcode.tpl' );
        } catch (StandardException $e) {
            return '';
        }
    }
}