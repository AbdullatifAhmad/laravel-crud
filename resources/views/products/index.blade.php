@extends('layouts.app')
@section('content')
<main class="container">
    <section>
        <div class="titlebar">
            <h1>Products</h1>
            <a href="{{ route('products.create')}}" class="btn-link">Add Product</a>
        </div>
         {{-- This is the code that displays the success message --}}
        @if ($massage = Session::get('success'))
            <script type="text/javascript">
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: 'success',
                    title: '{{$massage}}'
                    })
            </script>
        @endif

        <div class="table">
            <div class="table-filter">
                <div>
                    <ul class="table-filter-list">
                        <li>
                            <a href="{{ route('products.index')}}" class="table-filter-link link-active">All</a>
                        </li>
                    </ul>
                </div>
            </div>
            <form method="GET" action="{{ route('products.index')}}" accept-charset="UTF-8" role="search">
                <div class="table-search">   
                    <div>
                        <button class="search-select">
                        Search Product
                        </button>
                        <span class="search-select-arrow">
                            <i class="fas fa-caret-down"></i>
                        </span>
                    </div>
                    <div class="relative">
                        <input class="search-input" type="text"  placeholder="Search product..." name="search" value="{{ request('search') }}">
                    </div>
                </div>
            </form>
            <div class="table-product-head">
                <p>Image</p>
                <p>Name</p>
                <p>Description</p>
                <p>Category</p>
                <p>Price</p>
                
                <p>Actions</p>
            </div style="display: flex">
            <div class="table-product-body">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <img src="{{asset('images/' . $product->image)}}"/>
                        <p>{{$product->name}}</p>
                        <p>{{$product->description}}</p>
                        <p>{{$product->category}}</p>
                        <p>{{$product->price}}</p>
                        
                        
                        <div>     
                            <a href="{{ route('products.edit', $product->id)}}" class="btn-link btn btn-success" style="padding-top: 4px;padding-bottom: 4px">
                                <i class="far fa-edit"></i>
                            </a>
                            <form method="post" action="{{ route('products.destroy', $product->id)}}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger" onclick="deleteConfirm(event)">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <p>No products found</p>
                @endif

            </div>
            <div class="table-paginate">
                {{$products->links('layouts.pagination')}}
            </div>
        </div>
    </section>
</main>

<script>
    window.deleteConfirm = function (e) {
        e.preventDefault();
        var form = e.target.form;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
            })
    }
</script>
@endsection