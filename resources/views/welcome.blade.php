@extends('layout.main')
@section('title')
    Create Item
@endsection
@section('body')
    <div class="container">
        <form method="post" action="{{url('/addTarget')}}" enctype="multipart/form-data" style="margin-top: 50px">
            @csrf
            <div class="row">
                <div class="col-md-5 my-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background: #0C0C0C;color: #FEFEFE">Image Target
                            </div>
                        </div>
                        <input type="file" class="form-control" id="inlineFormInputGroupUsername" name="picture">
                    </div>
                </div>
                <div class="col-md-2 my-1"></div>
                <div class="col-md-5 my-1">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background: #0C0C0C;color: #FEFEFE">Assets Bundle
                            </div>
                        </div>
                        <input type="file" class="form-control" id="inlineFormInputGroupUsername" name="model">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 my-1"></div>
                <div class="col-md-2 my-1">
                    <button type="submit" class="btn btn-warning" style="margin-left: 30px">submit</button>
                </div>
                <div class="col-md-5 my-1"></div>
            </div>
        </form>
        <hr>

    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (count($allItems) > 0)
        <div>
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-9">
                    <table class="table">
                        <thead class="thead-dark">
                        <!--                <th scope="col">Target Name</th>-->
                        <th scope="col">Image Target</th>
                        <th scope="col">Asset Path</th>
                        <th scope="col">Action</th>
                        </thead>
                        <tbody>
                        @foreach($allItems as $value)
                            <tr>
                            <!--                    <td>{{$value->name}}</td>-->
                                <td><img src="{{$value->picture}}" alt="" style="height: 100px;width: 100px"></td>
                                <td style="padding-top: 50px">{{$value->model}}</td>
                                <td style="padding-top: 30px">
                                <!--                        <a class="btn btn-success" href="{{url('publish')}}" style="">Publish Changes</a>-->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2">
                    <div>
                        <a class="btn btn-success" href="{{url('publish')}}" style="">Publish Changes</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
