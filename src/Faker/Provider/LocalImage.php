<?php

namespace Faker\Provider;

/**
 * LocalImage provider depends on local folder with images
 */
class LocalImage extends \Faker\Provider\Base
{
    private static $loadedFiles = NULL;

    /**
     * 
     */
    private static function selectRandomImage($sourceDir)
    {
        if (self::$loadedFiles == NULL) {
            self::$loadedFiles = array();
            if ($handle = opendir($sourceDir)) {
                while (false !== ($entry = readdir($handle))) {
					if ($entry == '.' || $entry == '..') {
						continue;
					}
                    $loadedFiles[] = $entry;
                }
            }
        }

		if (empty($loadedFiles)) {
			return false;
		}

		return $loadedFiles[rand(count($loadedFiles) - 1)];
    }

    /**
     * Select random image from local folder and return
     *
     * @example '/path/to/dir/13b73edae8443990be1aa8f1a483bc27.jpg'
     */
    public static function localImage($sourceDir, $dir = '/tmp', $fullPath = true)
    {
        // Validate source directory path
        if (!is_dir($sourceDir) || !is_readable($sourceDir)) {
            throw new \InvalidArgumentException(sprintf('Cannot read from directory "%s"', $sourceDir));
        }

        // Validate directory path
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \InvalidArgumentException(sprintf('Cannot write to directory "%s"', $dir));
        }

        // Generate a random filename. Use the server address so that a file
        // generated at the same time on a different server won't have a collision.
        $name = md5(uniqid(empty($_SERVER['SERVER_ADDR']) ? '' : $_SERVER['SERVER_ADDR'], true));
        $filename = $name .'.jpg';
        $filepath = $dir . DIRECTORY_SEPARATOR . $filename;

        $localImage = static::selectRandomImage($sourceDir);
        $success = copy($sourceDir . DIRECTORY_SEPARATOR . $localImage, $filepath);

        if (!$success) {
            return false;
        }

        return $fullPath ? $filepath : $filename;
    }
}
