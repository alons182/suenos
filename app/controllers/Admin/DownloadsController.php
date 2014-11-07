<?php namespace app\controllers\Admin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Suenos\UploadHandler as Upload;

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
                'size' => File::size($file),
                'name'  => explode("//",$file)[1]

            );
            $filesArray[] = $fileArray;
        }


        return View::make('admin.downloads.index')->withFiles(new Collection($filesArray));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $file = Input::file('file');

        $upload = new Upload;


        try {
           // $upload->process($file);
        } catch(Exception $exception){
            // Something went wrong. Log it.
            Log::error($exception);
            $error = array(
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'error' => $exception->getMessage(),
            );
            // Return error
            return Response::json($error, 400);
        }

        // If it now has an id, it should have been successful.
        /*if ( $upload->id ) {
            $newurl = URL::asset($upload->publicpath().$upload->filename);

            // this creates the response structure for jquery file upload
            $success = new stdClass();
            $success->name = $upload->filename;
            $success->size = $upload->size;
            $success->url = $newurl;
            $success->thumbnailUrl = $newurl;
            $success->deleteUrl = action('UploadController@delete', $upload->id);
            $success->deleteType = 'DELETE';
            $success->fileID = $upload->id;

            return Response::json(array( 'files'=> array($success)), 200);
        } else {
            return Response::json('Error', 400);
        }*/
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $path = dir_downloads_path();

        if(File::exists($path.$id))
        {
            File::delete(dir_downloads_path() . $id);

        }

	}


}
