<?php


namespace App\Util;


use App\Enums\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Helper
{
    const HTTP = 'http';
    const HTTPS = 'https';
    const PARENT_DIR = '..';

    public static function getFileExtensionFromPath(string $filepath)
    {
        if (strpos($filepath, '.') != false) {
            $splitValue = explode('.', $filepath);
            return end($splitValue);
        }
        return '';
    }

    /**
     * @param string $projectDir
     * @return string
     */
    public static function getPublicDir(string $projectDir)
    {
        return $projectDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . (getenv('APP_ENV') === 'dev' ? 'public' : 'build') . DIRECTORY_SEPARATOR;
    }

    /**
     * Generates unique filename based on current time
     * @param string|null $prefix
     * @return string
     */
    public static function generateFilename(string $prefix = 'upload')
    {
        return sprintf('%s-%s-%s', $prefix, (new \DateTime())->format('YmdHis'), uniqid());
    }

    public static function uploadFile(UploadedFile $file, string $uploadDir) {
        if ($file) {
            $extension = $file->guessClientExtension();
            if (in_array($extension, Image::ALLOWED_EXTENSIONS)) {
                $filename = self::generateFilename() . '.' . $extension;
                $file->move($uploadDir, $filename);
                return $file->getPath();
            }
        }
        return null;
    }
}