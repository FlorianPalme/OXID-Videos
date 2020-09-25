<?php
/**
 * @author  Florian Palme <info@florian-palme.de>
 * @package FlorianPalme\OXIDVideos
 * @see
 */

namespace FlorianPalme\OXIDVideos\Core;


class Config extends Config_parent
{

    /**
     * video config for category videos
     *
     * @var array
     */
    protected $fpOXIDVideosCategoryConfig;

    /**
     * video config for actions videos
     *
     * @var array
     */
    protected $fpOXIDVideosActionsConfig;

    /**
     * returns video config for categories
     *
     * @return array
     */
    public function fpOXIDVideosGetCategoryConfig(): array
    {
        if ($this->fpOXIDVideosCategoryConfig === null) {
            $this->fpOXIDVideosCategoryConfig = $this->fpOXIDVideosGetConfigFor('categories');
        }

        return $this->fpOXIDVideosCategoryConfig;
    }

    /**
     * returns video config for categories
     *
     * @return array
     */
    public function fpOXIDVideosGetActionsConfig(): array
    {
        if ($this->fpOXIDVideosActionsConfig === null) {
            $this->fpOXIDVideosActionsConfig = $this->fpOXIDVideosGetConfigFor('actions');
        }

        return $this->fpOXIDVideosActionsConfig;
    }

    /**
     * returns video config values for specific type
     *
     * @param string $configType
     *
     * @return array
     */
    protected function fpOXIDVideosGetConfigFor(string $configType): array
    {
        $attributes = [
            'autoplay' => $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_autoplay'),
            'controls' => $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_controls'),
            'loop' => $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_loop'),
            'preload' => $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_preload'),
            'muted' => $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_muted'),
            'width' => (int) $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_width'),
            'height' => (int) $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_height'),
            'playsinline' => (bool) $this->fpOXIDVideoGetConfigValue('fpoxidvideos_' . $configType . '_playsinline'),
        ];

        return $attributes;
    }

    /**
     * returns an config value for the module
     *
     * @param string   $varName
     * @param int|null $shopId
     *
     * @return object
     */
    public function fpOXIDVideoGetConfigValue(string $varName, int $shopId = null)
    {
        return $this->getShopConfVar($varName, $shopId, 'module:fp/oxid-videos');
    }
}