<?php namespace Suenos\Products;

use Laracasts\Presenter\PresentableTrait;

class Product extends \Eloquent {

    use PresentableTrait;
    protected $table = 'products';

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'promo_price', 'discount', 'image', 'sizes', 'colors', 'relateds', 'published', 'featured'
    ];

    /**
     * Path to presenter for a profile
     * @var string
     */
    protected $presenter = 'Suenos\Products\ProductPresenter';

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    public function scopeSearchSlug($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('slug', '=', $search)
                ->where('published', '=', 1);
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where(function ($query)
        {
            $query->where('featured', '=', 1)
                ->where('published', '=', 1);
        });
    }

    public function setPriceAttribute($price)
    {
        $this->attributes['price'] = (number($price) == "") ? 0 : number($price);
    }

    public function setPromoPriceAttribute($promo_price)
    {
        $this->attributes['promo_price'] = (number($promo_price) == "") ? 0 : number($promo_price);
    }

    public function setDiscountAttribute($discount)
    {
        $this->attributes['discount'] = (number($discount) == "") ? 0 : number($discount);
    }

    public function setSizesAttribute($sizes)
    {
        $this->attributes['sizes'] = json_encode($sizes);
    }

    public function setColorsAttribute($sizes)
    {
        $this->attributes['colors'] = json_encode($sizes);
    }

    public function setRelatedsAttribute($relateds)
    {
        $this->attributes['relateds'] = json_encode($relateds);
    }

    public function categories()
    {
        return $this->belongsToMany('Suenos\Categories\Category');
    }

    public function details()
    {
        return $this->hasOne('Suenos\Orders\Detail');
    }

    public function photos()
    {
        return $this->hasMany('Suenos\Photos\Photo');
    }

}


