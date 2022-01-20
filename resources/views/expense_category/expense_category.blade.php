@extends('layouts.master')
@section('title', 'Expense Category')
@section('main_content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <form class="form-horizontal" method="POST" action="{{ route('expense-category-save')}}">
                @csrf
          <div class="card-body">
            <a href="{{ route('expense-category-list')}}" class="btn btn-success btn-sm text-white rightButtonairline">
              <i class="mdi mdi-format-list-bulleted"></i> Expense Category List </a>
            <h4 class=""> Add Expense Category </h4><br>
            <div class="form-group row">
                <label for="name" class="col-sm-2 text-end control-label col-form-label"> Expense Name</label>
                <div class="col-sm-4">
                   <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"  placeholder="Title">
                   @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror 
                </div>
            </div>
          </div>
          <div class="border-top">
            <div class="card-body">
              <button type="submit" class="btn btn-primary SubmitBtnLeft">
                Save
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection