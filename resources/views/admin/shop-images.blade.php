@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/imagePreviewModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-2 col-sm-4">
          @isset($logo)
          <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-fluid" alt="...">
          @endisset
        </div>
        <div class="col-8 col-sm-12 text-center">
          <h2>{{ $shop->name }}</h2>
          <h5>{{ $shop->address }}</h5>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('admin.shop-nav-tabs')
                </div>

                <div class="card-body">
                  <div class="col text-right">
                    <a class="btn btn-info" type="button" role="button" href="{{ route('admin.shop.images.upload', ['id' => $shop->id]) }}">Upload</a>
                  </div>
                  <div class="row justify-content-center text-center">
                    <div class="col-3">
                      <h4>Logo</h4>
                    @isset($logo)
                        <a href="#" data-toggle="modal" data-target="#deleteModal" data-form-action="{{ route('shopowner.shop.images.delete', ['id' => $logo->id]) }}" data-id="{{ $logo->id }}" data-src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}">
                          <img src="{{ asset('img/'.Auth::user()->id.'/'.$logo->path) }}" class="img-thumbnail" alt="...">
                        </a>
                    @else
                      <img src="https://via.placeholder.com/1000?text=No+Image" class="img-fluid img-thumbnail" alt="...">
                    @endisset
                    </div>
                  </div>
                  <div class="row justify-content-center text-center">
                    <div class="col-3">
                      <h4>Images</h4>
                    </div>
                  </div>
                  <div class="row">
                    @isset($images)
                      @foreach($images as $image)
                        <div class="col-6">
                          <a href="#" data-toggle="modal" data-target="#deleteModal" data-form-action="{{ route('shopowner.shop.images.delete', ['id' => $image->id]) }}" data-id="{{ $image->id }}" data-src="{{ asset('img/'.Auth::user()->id.'/'.$image->path) }}">
                            <img src="{{ asset('img/'.Auth::user()->id.'/'.$image->path) }}" class="img-thumbnail" alt="...">
                          </a>
                        </div>
                      @endforeach
                    @endisset
                  </div>
                </div>
            </div>

            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" name="deleteModal">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body text-center">
                    <div class="row">
                      <div class="col">
                        <img src="#" class="img-fluid" id="modalImagePreview" alt="...">
                      </div>
                    </div>
                    <form class="" action="#" method="post">
                      @csrf
                      <!-- <div class="row">
                        <div class="col-md-12">
                          <p>Please confirm that you want to delete the following image.</p>
                          <h4 id='name'></h4>
                        </div>
                      </div> -->
                      <div class="row">
                        <div class="col-md-12 justify-content-center">
                          <button class="btn btn-danger col-md-6" id="deleteButton" type="submit">Delete</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
