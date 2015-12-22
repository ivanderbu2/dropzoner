<?php

namespace Codingo\Dropzoner\Repositories;

use Codingo\Dropzoner\Events\ImageWasDeleted;
use Codingo\Dropzoner\Events\ImageWasUploaded;
use Intervention\Image\ImageManager;

class UploadRepository
{
    /**
     * Upload Single Image
     *
     * @param $input
     * @return mixed
     */
    public function upload($input)
    {
        $validator = \Validator::make($input, config('dropzoner.validator'), config('dropzoner.validator-messages'));

        if ($validator->fails()) {

            return \Response::json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }

        $photo = $input['file'];

        $originalName = $photo->getClientOriginalName();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - 4);

        $filename = $this->sanitize($originalNameWithoutExt);
        $allowed_filename = $this->createUniqueFilename( $filename );

        $filenameExt = $allowed_filename .'.jpg';

        $manager = new ImageManager();
        $image = $manager->make( $photo )->encode(config('dropzoner.encode'))->save(config('dropzoner.upload-path') . $filenameExt );

        if( !$image ) {

            return \Response::json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500
            ], 500);

        }

        //Fire ImageWasUploaded Event
        event(new ImageWasUploaded($originalName, $filenameExt));

        return \Response::json([
            'error' => false,
            'code'  => 200,
            'filename' => $filenameExt
        ], 200);
    }

    /**
     * Delete Single Image
     *
     * @return mixed
     */
    public function delete()
    {
        $upload_path = config('dropzoner.upload-path');

        $server_filename = \Input::get('id');
        $full_path = $upload_path . $server_filename;

        if (\File::exists($full_path)) {
            \File::delete($full_path);
        }

        event(new ImageWasDeleted($server_filename));

        return \Response::json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    /**
     * Check upload directory and see it there a file with same filename
     * If filename is same, add random 5 char string to the end
     *
     * @param $filename
     * @return string
     */
    private function createUniqueFilename( $filename )
    {
        $full_size_dir = config('dropzoner.upload-path');
        $full_image_path = $full_size_dir . $filename . '.jpg';

        if ( \File::exists( $full_image_path ) )
        {
            // Generate token for image
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken;
        }

        return $filename;
    }

    /**
     * Create safe filenames for server side
     *
     * @param $string
     * @param bool $force_lowercase
     * @param bool $anal
     * @return mixed|string
     */
    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}