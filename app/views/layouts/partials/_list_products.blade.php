<div class="products">
       @forelse($products as $product)
            <div class="product">
                   <figure class="img">
                       @if($product->image)
                            <a href="{{ URL::route('product_path', [$product->categories->last()->slug, $product->slug]) }}"><img src="{{ photos_path('products') }}/thumb_{{ $product->image }}" alt="{{ $product->name }}" width="200" height="145" /></a>
                       @else
                           <a href="{{ URL::route('product_path', [$product->categories->last()->slug, $product->slug]) }}"><img src="holder.js/189x145/text:No-image" alt="{{ $product->name }}" width="200" height="145" /></a>
                       @endif
                   </figure>
                   <div class="min-description">
                       {{ $product->name }}
                   </div>
                   <div class="price">
                       {{ money($product->price, '₡') }}
                   </div>
                   <a href="#" class="btn btn-purple">Agregar al carro</a>
           </div>
       @empty
        <p>No hay articulos en esta categoria</p>
       @endforelse

</div>