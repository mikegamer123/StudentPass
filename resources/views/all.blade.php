<x-header :currPage="$tableParams['index']" :userLogged=$userLogged></x-header>
<div class="app-content content" style="overflow: scroll;">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body" ><!-- Chart -->
            <div class="row match-height" style="justify-content: space-between;">
                <h2 class="mt-3">{{$tableParams["title"]}}</h2>
                <table class="table">
                    <a class="pt-3" href="/add/{{$tableParams["model"]}}"><button style="width: 100px" type="button" class="btn btn-primary">Add</button></a>
                @foreach($tableParams["table"] as $header)
                    <th scope="col">{{$header}}</th>
                    @endforeach
                    <th>Edit</th>
                    <th>Delete</th>
                    @if(isset($tableParams["hasPicture"]))<th>Slika</th>@endif
                    @foreach($tableParams["tableVals"] as $row)
                        <tr>
                            <?php
                            $i = 0;
                            ?>
                            @foreach($row as $val)
                                <td>@if(isset($tableParams["hasPicture"]) && $i == count($row)-1)<a @if(!is_null($val)) href="/{{$val}} @endif">@if(isset($val)) Pogledajte sliku @else N/A @endif</a>@else
                                        @if(isset($val)){{$val}}@else N/A @endif @endif</td>
                                <?php
                                    $i++;
                                    ?>
                            @endforeach
                            <td>
                                <form action="{{$tableParams['model']}}/edit/{{$row[0]}}" method="get">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </td>

                                <td>
                                    <form action="{{$tableParams['model']}}/delete/{{$row[0]}}" class="delete-form" method="get">
                                        <a href=""><button type="submit" class="btn delete-btn btn-danger">Delete</button></a>
                                    </form></td>
                                @if(isset($tableParams["hasPicture"]))
                                    <td>
                                        <form enctype="multipart/form-data" action="images/{{$tableParams['model']}}/{{$row[0]}}" method="post">
                                            <input type="file" name="image_upload"/>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <button type="submit" class="btn btn-primary">Dodaj sliku</button>
                                        </form>
                                    </td>
                                @endif
                        </tr>
                    @endforeach
                </table>
                @if(isset($tableParams["tableReviewType"]))
                    <h2 class="mt-3">Tipovi recenzija za kategoriju</h2>
                    <table class="table">
                        <a class="pt-3" href="/add/reviewTypes"><button style="width: 100px" type="button" class="btn btn-primary">Add</button></a>
                        @foreach($tableParams["tableReviewType"] as $header)
                            <th scope="col">{{$header}}</th>
                        @endforeach
                        <th>Edit</th>
                        <th>Delete</th>
                        @foreach($tableParams["tableReviewTypeVals"] as $row)
                            <tr>
                                @foreach($row as $val)
                                    <td>@if(isset($val)){{$val}}@else N/A @endif</td>
                                @endforeach
                                <td>
                                    <form action="reviewTypes/edit/{{$row[0]}}" method="get">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                    </td>

                                    <td>
                                        <form action="reviewTypes/delete/{{$row[0]}}" class="delete-btn" method="get">
                                            <a href=""><button type="submit" class="btn delete-btn btn-danger">Delete</button></a>
                                        </form>
                                    </td>
                            </tr>
                        @endforeach
                    </table>
                @endif

                @if(isset($tableParams["tableStudyProgram"]))
                    <h2 class="mt-3">Smerovi i fakulteti</h2>
                    <table class="table">
                        <a class="pt-3" href="/add/studyPrograms"><button style="width: 100px" type="button" class="btn btn-primary">Add</button></a>
                        @foreach($tableParams["tableStudyProgram"] as $header)
                            <th scope="col">{{$header}}</th>
                        @endforeach
                        <th>Edit</th>
                        <th>Delete</th>
                        @foreach($tableParams["tableStudyProgramVals"] as $row)
                            <tr>
                                @foreach($row as $val)
                                    <td>@if(isset($val)){{$val}}@else N/A @endif</td>
                                @endforeach
                                <td>
                                    <form action="studyPrograms/edit/{{$row[0]}}" method="get">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </td>

                                <td>
                                    <form action="studyPrograms/delete/{{$row[0]}}" class="delete-btn" method="get">
                                        <a href=""><button type="submit" class="btn delete-btn btn-danger">Delete</button></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif

            </div>
            @if(isset($tableParams["hasConnections"]))
                <h2>Poveznice</h2>
                <div class="row match-height" style="flex-direction: column;">
                    <form method="post" action="@if(isset($tableParams["extraConnections"])) conn/add/{{$tableParams["connections"][2]}}_{{$tableParams["connections"][5]}} @else connection/{{$tableParams["connections"][2]}}_{{$tableParams["connections"][5]}}@endif">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="card">
                                    <fieldset class="form-group">
                                        <div class="card-header">
                                            <h4 class="card-title">{{$tableParams["connections"][0]}}</h4>
                                        </div>
                                        <select class="form-control" name="{{$tableParams["connections"][2]}}_id">
                                            @foreach($tableParams["connections"][1] as $model)
                                                <option value="{{$model["id"]}}">{{$model["name"]}}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12">
                                <div class="card">
                                    <fieldset class="form-group">
                                        <div class="card-header">
                                            <h4 class="card-title">{{$tableParams["connections"][3]}}</h4>
                                        </div>
                                        <select class="form-control" name="{{$tableParams["connections"][5]}}_id">
                                            @foreach($tableParams["connections"][4] as $model)
                                                <option value="{{$model["id"]}}">{{$model["name"]}}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 d-flex" style="align-items: center;"><input type="submit" class="btn btn-primary" name="submit" value="Dodaj"/></div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    </form>
                </div>
            @endif
        </div>
        @if(isset($tableParams["tableConnection"]))
            <div class="row match-height" style="justify-content: space-between;">
            <h2 class="mt-3">{{$tableParams["tableConnectionTitle"]}}</h2>
            <table class="table">
                @foreach($tableParams["tableConnection"] as $header)
                    <th scope="col">{{$header}}</th>
                @endforeach
                <th>Delete</th>
                @foreach($tableParams["tableConnectionVals"] as $row)
                    <tr>
                        @foreach($row as $val)
                            <td>@if(isset($val)){{$val}}@else N/A @endif</td>
                        @endforeach
                        <td>
                            <form action="{{$tableParams["tableConnectionModel"]}}/delete/{{$row[0]}}" class="delete-form" method="get">
                                <a href=""><button type="submit"  class="btn delete-btn btn-danger">Delete</button></a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            </div>
        @endif

    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<x-footer></x-footer>
