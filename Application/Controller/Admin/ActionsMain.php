<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Application\Controller\Admin;


use FlorianPalme\OXIDVideos\Core\UtilsFile;
use FlorianPalme\OXIDVideos\Core\UtilsVideo;
use OxidEsales\Eshop\Application\Model\Actions;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

class ActionsMain extends ActionsMain_parent
{
    /**
     * @inheritDoc
     */
    public function save()
    {
        /** @var UtilsFile $utilsFile */
        $utilsFile = \OxidEsales\Eshop\Core\Registry::getUtilsFile();
        $utilsFile->fpOXIDVideosAllowVideoUpload();

        parent::save();

        $utilsFile->fpOXIDVideosDisallowVideoUpload();

        // TODO check if uploaded file is a video file
    }

    /**
     * @inheritDoc
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function deletePicture()
    {
        $oxid = $this->getEditObjectId();
        $field = Registry::getRequest()->getRequestParameter('masterPicField');
        if (empty($field)) {
            return;
        } elseif ($field === 'fpoxidvideos_video') {
            /** @var \FlorianPalme\OXIDVideos\Application\Model\Actions $category */
            $action = oxNew(Actions::class);
            $action->load($oxid);
            $this->fpOXIDVideosDeleteCatVideo($action);
        }

    }

    /**
     * Deletes the category video
     *
     * @param Actions $category
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \Exception
     */
    protected function fpOXIDVideosDeleteCatVideo(Actions $action)
    {
        if ($action->isDerived()) {
            return;
        }

        $videoName = $action->oxactions__fpoxidvideos_video->value;

        $action->oxactions__fpoxidvideos_video = new Field();
        $action->save();

        /** @var UtilsVideo $utilsVideo */
        $utilsVideo = oxNew(UtilsVideo::class);
        $utilsVideo->safeDeleteVideo($videoName);
    }
}