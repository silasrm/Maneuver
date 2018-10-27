<?php namespace Fadion\Maneuver\Traits;

/**
 * Trait ForcedFilesTrait
 * @package Fadion\Maneuver\Traits
 */
trait ForcedFilesTrait
{
    /**
     * @var false|boolean Indicate if is to add the forced files/folders list to upload list
     */
    protected $withForcedFiles = false;

    /**
     * @param array $source
     * @return array
     */
    public function addForcedFiles(array $source)
    {
        // Load the forced files/folders array from config.
        $list = config('maneuver.forced');

        if (!empty($list) && is_array($list)) {
            // If 'composer.json' is in list but 'vendor' or 'vendor/' isn't, put vendor in list.
            if (in_array('composer.json', $list)
                && !in_array('vendor', $list)
                && !in_array('vendor/', $list)) {
                $list[] = 'vendor';
            }

            foreach ($list as $forced) {
                foreach (\File::allFiles(base_path() . '/' . $forced) as $file) {
                    $path = str_replace(base_path() . '/', '', $file->getPathname());
                    array_push($source, $path);
                }
            }
        }

        return $source;
    }
}