<?php

use Illuminate\Support\Collection;

class DownloadsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $path = dir_downloads_path();

        File::exists($path) or File::makeDirectory($path);
        $files =File::files($path);
        $filesArray = [];

        foreach ($files as $file)
        {
            $fileArray = array(
                'type' => File::extension($file),
                'name'  => explode("//",$file)[1]

            );
            $filesArray[] = $fileArray;
        }

        return View::make('downloads.index')->withFiles(new Collection($filesArray));
	}





}
