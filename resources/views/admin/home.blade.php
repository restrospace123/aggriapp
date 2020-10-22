@extends('layouts.admin')

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('dashboard-status'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('dashboard-status') }}</strong>
                    </div>
                    @endif

                </div>

                <div class="card-body">
                    <a href="add-exchange" class="btn btn-primary">Add Income Or Expences</a>

                    <br />

                </div>

                <div class="card-body">
                    <table id="list" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>On Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @if(!empty($list))
                            @foreach($list as $element)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>@if($element->type_id == 1) Income @else Expenses @endif</td>
                                <td>{{$element->amount}}</td>
                                <td>{{$element->ondate}}</td>
                                <td>
                                    <a class="btn" href="edit-exchange?edit={{$element->id}}"><i class="fa fa-edit" style="font-size:15px;"></i></a>
                                    <a class="btn" href="delete-exchange?delete={{$element->id}}" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" style="font-size:15px;"></i></i></a>
                                </td>
                            </tr>
                            @endforeach

                            @else
                            <tr>
                                <td colspan="5">Empty - No Records Found.</td>

                            </tr>
                            @endif


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>On Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

            <br><br>

            <div class="card-header">{{ __('Report Dashboard') }}</div>

            <div class="card-body">
                @if (session('dashboard-status'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('dashboard-status') }}</strong>
                </div>
                @endif

            </div>

            <div class="card-body">
            <?php
            if(session('report')){
            
            $report = explode(',', session('report'));

            $income   = $report[0];
            $expenses = $report[1];
            $start    = $report[2];
            $end      = $report[3];
            }
            
            
            ?>

            

            <form method="POST" action="{{ route('exchange.report') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="ondate" class="col-md-4 col-form-label text-md-right">{{ __('Start Date') }}</label>

                            <div class="col-md-6">
                                <input id="start" type="date" class="form-control" name="start" value="<?php if(isset($start)){ echo $start; } ?>" required autocomplete="start">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('End Date') }}</label>

                            <div class="col-md-6">
                                <input id="end" type="date" class="form-control" name="end" value="<?php if(isset($end)){ echo $end; } ?>" required autocomplete="end">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <br><br>

                    <div class="row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Income') }} - @if (session('report')) {{$income}} @endif</label>
                    </div>

                    <div class="row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Expenses') }} - @if (session('report')) {{$expenses}} @endif</label>
                    </div>



            </div>
        </div>


    </div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" type="text/javascript"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $j(document).ready(function() {
        $j('#list').DataTable({
            "bSort": false
        });
    });
</script>
@endsection