<x-header :currPage="$input['index']" :userLogged=$userLogged></x-header>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body" ><!-- Chart -->
            <h2 class="mt-3">{{$input["title"]}}</h2>
            <div class="row match-height" style="flex-direction: column;">
                <form method="post" id="add-form" @if(isset($input["inputFile"]))@if($input["inputFile"]) enctype="multipart/form-data" @endif @endif action="/requestHandler/{{$input["model"]}}">
                    <div class="row">
                        @if(isset($input["inputHidden"]))
                            <input type="hidden" name="{{$input["inputHidden"][0]}}" value="{{$input["inputHidden"][1]}}">
                            @endif
                @for($i=0;$i<count($input["inputs"]);$i++)
                        <div class="col-xl-4 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$input["inputs"][$i]}} @if(in_array($input["inputNames"][$i],$input["required"])) <span style="color:red">*</span> @endif</h4>
                                </div>
                                <div class="card-block">
                                    <div class="card-body">
                                        <fieldset class="form-group">
                                            <input type="{{$input["inputFormat"][$i]}}"  @if($input["inputFormat"][$i] == 'number') max="5" step="1" min="1" @endif name="{{$input["inputNames"][$i]}}" class="@if(in_array($input["inputNames"][$i],$input["required"])) required  @endif form-control">
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endfor
                            @if(isset($input["inputSelect"]))
                                <div class="col-xl-4 col-lg-6 col-md-12">
                                    <div class="card">
                                <fieldset class="form-group">
                                        <div class="card-header">
                                            <h4 class="card-title">{{$input["inputSelect"][0]}}</h4>
                                        </div>
                                    <select class="form-control" name="{{$input["inputSelect"][1]}}">
                                        @if(isset($input["userSelect"]))
                                            @foreach($input["inputSelect"][2] as $model)
                                                <option value="{{$model->id}}">{{$model->id}} {{$model->fname}} {{$model->lname}}</option>
                                            @endforeach
                                            @else
                                        @foreach($input["inputSelect"][2] as $model)
                                        <option value="{{$model->id}}">{{(isset($model->name))?($model->name):($model->title)}}</option>
                                        @endforeach
                                            @endif
                                    </select>
                                </fieldset>
                                    </div>
                                </div>
                            @endif
                            @if(isset($extra))
                                @foreach($extra as $key=>$value)
                                    <input type="hidden" name="{{$key}}" value="{{$value}}" />
                                @endforeach
                                @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <div class="d-flex w-100" style="justify-content: space-around;"><button data-modal="#validation-modal" type="submit" class="btn add-btn btn-primary">Dodaj</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<x-footer></x-footer>
