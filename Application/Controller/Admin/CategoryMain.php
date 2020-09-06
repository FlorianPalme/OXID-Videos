<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Application\Controller\Admin;


use FlorianPalme\OXIDVideos\Core\UtilsFile;
use FlorianPalme\OXIDVideos\Core\UtilsVideo;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;

class CategoryMain extends CategoryMain_parent
{
    /**
     * @inheritDoc
     */
    protected function updateCategoryOnSave($category, $params): Category
    {
        /** @var UtilsFile $utilsFile */
        $utilsFile = \OxidEsales\Eshop\Core\Registry::getUtilsFile();
        $utilsFile->fpOXIDVideosAllowVideoUpload();

        $return = parent::updateCategoryOnSave($category, $params);

        $utilsFile->fpOXIDVideosDisallowVideoUpload();

        // TODO check if uploaded file is a video file

        return $return;
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
            /** @var \FlorianPalme\OXIDVideos\Application\Model\Category $category */
            $category = oxNew(Category::class);
            $category->load($oxid);
            $this->fpOXIDVideosDeleteCatVideo($category);
        }

        return parent::deletePicture();
    }

    /**
     * Deletes the category video
     *
     * @param Category $category
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \Exception
     */
    protected function fpOXIDVideosDeleteCatVideo(Category $category)
    {
        if ($category->isDerived()) {
            return;
        }

        $videoName = $category->oxcategories__fpoxidvideos_video->value;

        $category->oxcategories__fpoxidvideos_video = new Field();
        $category->save();

        /** @var UtilsVideo $utilsVideo */
        $utilsVideo = oxNew(UtilsVideo::class);
        $utilsVideo->safeDeleteVideo($videoName);
    }
}