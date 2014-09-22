<?php namespace Suenos\Products;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Suenos\Categories\Category;
use Suenos\DbRepository;
use Suenos\Photos\Photo;


class DbProductRepository extends DbRepository implements ProductRepository  {

    protected $model;

    function __construct(Product $model)
    {
        $this->model = $model;
        $this->limit = 10;
    }

    public function store($data)
    {
        $data = $this->prepareData($data);
        $data['image'] = ($data['image']) ? $this->storeImage($data['image'], $data['name'], 'products', 640, null) : '';

        $product = $this->model->create($data);
        $this->sync_categories($product, $data['categories']);
        $this->sync_photos($product, $data);

        return $product;
    }
    public function update($id, $data)
    {
        $product = $this->model->findOrFail($id);
        $data = $this->prepareData($data);
        $data['image'] = ($data['image']) ? $this->storeImage($data['image'], $data['name'], 'products', 640, null) : $product->image;

        $product->fill($data);
        $product->save();
        $this->sync_categories($product, $data['categories']);

        return $product;
    }
    public function sync_categories($product, $categories)
    {
        $product->categories()->sync($categories);
    }


    public function sync_photos($product, $data)
    {
        if (isset($data['new_photo_file']))
        {
            $cant = count($data['new_photo_file']);
            foreach ($data['new_photo_file'] as $photo)
            {
                $filename = $this->storeImage($photo, 'photo_' . $cant --, 'products/' . $product->id, 50, null);
                $photos = new Photo;
                $photos->url = $filename;
                $photos->url_thumb = 'thumb_' . $filename;
                $product->photos()->save($photos);
            }
        }

    }

    public function destroy($id)
    {
        $product = $this->findById($id);
        $image_delete = $product->image;
        $photos_delete = $product->id;
        $product->delete();

        File::delete(dir_photos_path('products') . $image_delete);
        File::delete(dir_photos_path('products') . 'thumb_' . $image_delete);
        File::deleteDirectory(dir_photos_path('products') . $photos_delete);

        return $product;
    }


    public function findById($id)
    {
        return $this->model->with('categories')->findOrFail($id);
    }
    public function findBySlug($slug)
    {
        return $this->model->SearchSlug($slug)->first();
    }
    public function findByCategory($category)
    {
        $category = Category::searchSlug($category)->firstOrFail();

        $products = $category->products()->with('categories')->where('published', '=', 1)->paginate($this->limit);

        return  $products;
    }

    public function getAll($search)
    {
        if (isset($search['cat']) && ! empty($search['cat']))
        {
            $category = Category::with('products')->findOrFail($search['cat']);
            $products = $category->products();

        } else
        {
            $products = $this->model;
        }

        if (isset($search['q']) && ! empty($search['q']))
        {
            $products = $products->Search($search['q']);
        }

        if (isset($search['published']) && $search['published'] != "")
        {
            $products = $products->where('published', '=', $search['published']);
        }

        return $products->with('categories')->orderBy('created_at', 'desc')->paginate($this->limit);
    }

    public function getFeatured()
    {

        $products = $this->model->where('featured', '=', 1)->paginate($this->limit);

        return  $products;
    }

    /**
     * get last products for the dashboard page
     * @return mixed
     */
    public function getLasts()
    {
        return $this->model->orderBy('products.created_at', 'desc')
            ->limit(6)->get(['products.id', 'products.name']);
    }

    /**
     * @param $data
     * @return mixed
     */
    private function prepareData($data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['sizes'] = existDataArray($data, 'sizes');
        $data['colors'] = existDataArray($data, 'colors');
        $data['relateds'] = existDataArray($data, 'relateds');

        return $data;
    }
}