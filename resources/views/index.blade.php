<x-header :currPage="0" :userLogged=$userLogged></x-header>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- Chart -->
            <div class="row match-height">
                <div class="col-12">
                    <div class="">
                        <div id="gradient-line-chart1" class="height-250 GradientlineShadow1"></div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row match-height">
                <div class="col-xl-4 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Nedavno ulogovani</h4>
                            <a class="heading-elements-toggle">
                                <i class="fa fa-ellipsis-v font-medium-3"></i>
                            </a>
                        </div>
                        <div class="card-content">
                            <div id="recent-buyers" class="media-list">
                                <?php
                                $i = 0;
                                ?>
                                @foreach($users as $user)

                                    <a href="#" class="media border-0">
                                        <div class="media-left pr-1">
                            <span class="avatar avatar-md avatar-online">
                                <img class="media-object rounded-circle" src="@if(isset($images[$i]->path)){{$images[$i]->path}}@endif">
                                <i></i>
                            </span>
                                        </div>
                                        <div class="media-body w-100">
                            <span class="list-group-item-heading">{{$user->fname}} {{$user->lname}}

                            </span>
                                            <span class="list-group-item-heading">@if(isset($userLogs[$i]->user_agent)){{$userLogs[$i]->user_agent}} at: {{$userLogs[$i]->login_time}}@endif

                            </span>
                                            <p class="list-group-item-text text-right mb-0">
                                                <span class="blue-grey lighten-2 font-small-3"> #{{$user->id}} </span>
                                            </p>
                                        </div>
                                    </a>
                                        <?php
                                        $i++;
                                        ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h4 class="card-title">Nedavni postovi</h4>
                                <h6 class="card-subtitle text-muted">Stisnite na slike kako bi videli popust i post</h6>
                            </div>
                            <div id="carousel-area" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php
                                    $i = 0;
                                    ?>
                                    @foreach($posts as $post)
                                    <li data-target="#carousel-area" data-slide-to="{{$i}}" @if($i==0)class="active"@endif></li>
                                            <?php $i++;?>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                <?php
                                        $i = 0;
                                    ?>
                                    @foreach($posts as $post)

                                    <div class="carousel-item @if($i==0) active @endif">
                                        <img src="@if(isset($imagesPost[$i]->path)){{$imagesPost[$i]->path}} @endif" class="d-block w-100" alt="{{$i}}">
                                        <h3 class="text-center">{{$post->title}}</h3>
                                        <h4 class="text-center">Start:{{$post->startDate}} End:{{$post->endDate}}</h4>
                                        <h4 class="text-center">Cena:{{$post->discountedPrice}} Original:{{$post->originalPrice}}</h4>
                                    </div>
                                            <?php $i++;?>
                                         @endforeach
                                     </div>
                                     <a class="carousel-control-prev" href="#carousel-area" role="button" data-slide="prev">
                                         <span class="la la-angle-left" aria-hidden="true"></span>
                                         <span class="sr-only">Previous</span>
                                     </a>
                                     <a class="carousel-control-next" href="#carousel-area" role="button" data-slide="next">
                                         <span class="la la-angle-right icon-next" aria-hidden="true"></span>
                                         <span class="sr-only">Next</span>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="col-xl-4 col-lg-12">
                         <div class="card">
                             <div class="card-header">
                                 <h4 class="card-title">Novi korisnici</h4>
                                 <a class="heading-elements-toggle">
                                     <i class="fa fa-ellipsis-v font-medium-3"></i>
                                 </a>
                             </div>
                             <div class="card-content">
                                 <div id="recent-buyers" class="media-list">
                                     <?php
                                     $i = 0;
                                     ?>
                                @if(count($users) > 0)
                                @foreach($users as $user)

                                <a href="#" class="media border-0">
                                    <div class="media-left pr-1">
                            <span class="avatar avatar-md avatar-online">
                                <img class="media-object rounded-circle" src="@if(isset($images[$i]->path)){{$images[$i]->path}}@endif">
                                <i></i>
                            </span>
                                    </div>
                                    <div class="media-body w-100">
                            <span class="list-group-item-heading">{{$user->fname}} {{$user->lname}}

                            </span>
                                        <p class="list-group-item-text text-right mb-0">
                                            <span class="blue-grey lighten-2 font-small-3"> #{{$user->id}} </span>
                                        </p>
                                    </div>
                                </a>
                                                 <?php
                                                 $i++;
                                                 ?>
                                @endforeach
                                    @else
                                <span>Nema novih korisnika</span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics -->
        </div>
    </div>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<x-footer></x-footer>
