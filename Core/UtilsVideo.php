<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Core;


use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

class UtilsVideo
{

    /**
     * defines all columns in the database, where a video can be stored
     *
     * @var array
     */
    protected $videoDatabaseFields = [
        [
            'table' => 'oxcategories',
            'column' => 'fpoxidvideos_video',
        ],

        [
            'table' => 'oxactions',
            'column' => 'fpoxidvideos_video',
        ],
    ];

    /**
     * Deletes video, if not mentioned in database elsewhere (ignores content shortcodes)
     *
     * @param string $fileName
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function safeDeleteVideo(string $fileName)
    {
        $videoPath = $this->generateVideoPath($fileName);

        // check if file even exists
        if (!file_exists($videoPath)) {
            return;
        }

        // check, if video is defined elsewhere
        if ($this->isVideoMentionedInDatabase($fileName)) {
            return;
        }

        // delete video
        unlink($videoPath);
    }

    /**
     * generates path to video file
     *
     * @param string $fileName
     *
     * @return string
     */
    public function generateVideoPath(string $fileName): string
    {
        return Registry::getConfig()->getOutDir() . 'videos/' . $fileName;
    }

    /**
     * generates url to video file
     *
     * @param string $fileName
     *
     * @return string
     *
     * @throws StandardException
     */
    public function generateVideoUrl(string $fileName): string
    {
        $videoPath = $this->generateVideoPath($fileName);

        // check, if file still exists
        if (!file_exists($videoPath)) {
            /** @var StandardException $exception */
            $exception = oxNew(StandardException::class, 'video file does not longer exist', 465001);
            throw $exception;
        }

        return Registry::getConfig()->getOutUrl() . 'videos/' . $fileName;
    }


    /**
     * Checks, if the video is mentioned in database (ignores content shortcodes)
     *
     * @param string $videoName
     *
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function isVideoMentionedInDatabase(string $videoName): bool
    {
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

        /** @var TableViewNameGenerator $tableViewNameGenerator */
        $tableViewNameGenerator = oxNew(TableViewNameGenerator::class);

        foreach ($this->videoDatabaseFields as ['table' => $table, 'column' => $column]) {
            $tableView = $tableViewNameGenerator->getViewName($table);
            $sql = "SELECT COUNT(*) FROM $tableView WHERE $tableView.$column = '$videoName'";
            $result = $db->getOne($sql);

            if ($result) {
                return true;
            }
        }

        return false;
    }
}