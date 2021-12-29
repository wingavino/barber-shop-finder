@extends('layouts.app')

@section('custom-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/imagePreviewModal.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  @include('shop-nav-tabs')
                </div>

                <div class="card-body">
                  <div class="row">
                    @isset($images)
                    @foreach($images as $image)
                    <div class="col-6">
                      <a href="#" data-toggle="modal" data-target="#deleteModal" data-id="{{ $image->id }}" data-src="{{ asset('img/'.$shop->id.'/'.$image->path) }}">
                        <img src="{{ asset('img/'.$shop->id.'/'.$image->path) }}" class="img-thumbnail" alt="...">
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
