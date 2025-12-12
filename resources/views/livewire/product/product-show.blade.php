<x-card cardTitle='Detalles de los Productos'>
    <x-slot:cardTools>  
        <a href="{{route('products')}}" class="btn btn-primary">
            <i class="fas fa-arrow-circle-left"></i>  Regresar</a>
    </x-slot>
         
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="col-12">
                        <x-image :item="$product" size="400" class="product-image"/>
                        <img src="{{$product->imagen}}" class="product-image" alt="Product Image">
                    </div> 
                    <div class="col-12 product-image-thumbs">
                        <div class="product-image-thumbs">

                        </div>
                    </div>

                    <div class="col-12 col-sm-7">
                        <h3 class="my-3">{{ $product->nombre }}</h3>
                        <p>{{$product->descripcion}}</p>
                        
    <x-slot:cardTools>  
        <a href="{{route('products')}}" class="btn btn-primary">
            <i class="fas fa-arrow-circle-left"></i>  Regresar</a>
    </x-slot>
        
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-5">
                    <div class="col-12">
                        <x-image :item="$product" size="400" class="product-image"/>
                        <img src="{{$product->imagen}}" class="product-image" alt="Product Image">
                    </div> 
                    <div class="col-12 product-image-thumbs">
                        <div class="product-image-thumbs">

                        </div>
                    </div>

                    <div class="col-12 col-sm-7">
                        <h3 class="my-3">{{ $product->nombre }}</h3>
                        <p>{{$product->descripcion}}</p>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-card>
