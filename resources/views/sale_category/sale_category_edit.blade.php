@extends('layouts.master')
@section('title', 'Sale Category Update')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('sale-category-update', $category_info->id)}}">
                @csrf
          <div class="card-body">
            <h4 class="card-title"> Sale Category Update </h4>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Title</label>
                <div class="col-sm-4">
                   <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $category_info->title}}">
                   @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
            <div class="form-group row">
                <label for="country_code" class="col-sm-2 text-end control-label col-form-label"> Type</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <option value=""> Select</option>
                        <option value="1"  @if($category_info->type ==1) echo selected @endif> Flights </option>
                        <option value="2"  @if($category_info->type ==2) echo selected @endif> Hotels </option>
                        <option value="3"  @if($category_info->type ==3) echo selected @endif> Transfers </option>
                        <option value="4"  @if($category_info->type ==4) echo selected @endif> Activities </option>
                        <option value="5"  @if($category_info->type ==5) echo selected @endif> Holidays </option>
                        <option value="6"  @if($category_info->type ==6) echo selected @endif> Holidays </option>
                        <option value="7"  @if($category_info->type ==7) echo selected @endif> Others </option>
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