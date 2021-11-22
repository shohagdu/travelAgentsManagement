@extends('layouts.master')
@section('title', 'Towards Category')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('towards-category-update', $category_info->id )}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('towards-category-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Towards Category List </a>
            <h4 class=""> Towards Category </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Name</label>
                <div class="col-sm-4">
                   <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $category_info->title}}"  placeholder="Title">
                   @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="type" class="col-sm-2 text-end control-label col-form-label"> Towards Type</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <option value="">  Select</option>
                        <option value="19"  @if($category_info->type ==19) echo selected @endif> Credit </option>
                        <option value="20"  @if($category_info->type ==20) echo selected @endif> Debit </option>
                        
                    </select>
                </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-info SubmitBtnLeft">
                Update
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection