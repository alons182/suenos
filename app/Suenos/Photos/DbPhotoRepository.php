<?php namespace Suenos\Photos;

use Str;
use Image;
use File;
use Suenos\DbRepository;


class DbPhotoRepository extends DbRepository implements PhotoRepository {

    protected $model;

    function __construct(Photo $model)
    {
        $this->model = $model;

    }

    public function store($data)
    {
        $cant = count($this->getPhotos($data['product_id']));
        $data['url'] = ($data['photo']) ? $this->storeImage($data['photo'], 'photo_' . ++$cant, 'products/' . $data['product_id'], 50, null) : '';
        $data['url_thumb'] = 'thumb_' . $data['url'];

        $photo = $this->model->create($data);

        return $photo;
    }


    public function getPhotos($id)
    {
        return $this->model->where('product_id', '=', $id)->get();
    }

    public function storeImage($file, $name, $directory, $thumbWidth, $thumbHeight = null)
    {
        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $filename = Str::slug($name) . '.' . $extension;
        $path = dir_photos_path($directory);
        $image = Image::make($file["tmp_name"]);

        File::exists($path) or File::makeDirectory($path);

        $image->save($path . $filename)->resize($thumbWidth, $thumbHeight, function ($constraint)
        {
            $constraint->aspectRatio();
        })->save($path . 'thumb_' . $filename);

        return $filename;
    }


}