<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Core;


use OxidEsales\Eshop\Core\ConfigFile;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\FileCache;
use OxidEsales\Eshop\Core\Registry;

class Events
{
    /**
     * Führt bei Modul-aktivierung einige SQL-Befehle aus
     *
     * @access  public
     */
    public static function onActivate()
    {
        // Datenbank-Objekt auslesen
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);

        $sqlQueries = [];

        $sqlQueries[] = "alter table oxcategories
	add FPOXIDVIDEOS_VIDEO varchar(128) default null;";

        $sqlQueries[] = "alter table oxactions
	add FPOXIDVIDEOS_VIDEO varchar(128) default null;";

        foreach ($sqlQueries as $sqlQuery) {
            // MySQL-Fehler abfangen
            try {
                $result = $db->execute($sqlQuery);
            } catch (DatabaseErrorException $e) {
                // Ausser es sind keine "alread exists" fehler...
                if (!preg_match('/(already exists|Duplicate column name)/i', $e->getMessage())) {
                    throw $e;
                }
            }
        }

        // create video dir
        $config = Registry::getConfig();
        $videoDir = $config->getOutDir() . 'videos/';

        if (!is_dir($videoDir)) {
            mkdir($videoDir);
            file_put_contents($videoDir . '.gitkeep', '');
        }

        self::clearCache();
    }


    /**
     * Bei Modul-Deaktivierung
     */
    public static function onDeactivate()
    {
        self::clearCache();
    }


    /**
     * Löscht den TMP-Ordner sowie den Smarty-Ordner
     */
    protected static function clearCache()
    {
        /** @var FileCache $fileCache */
        $fileCache = oxNew(FileCache::class);
        $fileCache::clearCache();

        /** Smarty leeren */
        $tempDirectory = Registry::get(ConfigFile::class)->getVar("sCompileDir");
        $mask = $tempDirectory . "/smarty/*.php";
        $files = glob($mask);
        if (is_array($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }
}