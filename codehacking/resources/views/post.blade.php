@extends('layouts.blog-post')

@section('content')
 

                <!-- Blog Post -->

                <!-- Title -->
                <h1>{{$post->title}}</h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#">{{$post->user->name}}</a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted {{$post->created_at->diffForHumans()}}</p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="{{$post->photo->file}}" alt="">

                <hr>

                <!-- Post Content -->
               <p>{{$post->body}}</p>
                <hr>

                @if(Session::has('comment_message'))
                	{{session('comment_message')}}
                @endif
                <!-- Blog Comments -->
@if(Auth::Check())
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    

	 {!! Form::open(['method'=>'POST', 'action' => 'PostCommentsController@store']) !!}
	 <input type="hidden" value="{{$post->id}}" name="post_id">

	 <div class="form-group">

	  {!! Form::label('body','Body:') !!}
	  {!! Form::textarea('body',null,['class'=>'form-control','rows'=>3]) !!}
	  
	 </div> 
	 <div class="form-group">

	  {!! Form::submit('Submit comment',['class' => 'btn btn-primary']) !!}
	  
	 </div>

	 {!! Form::close() !!}
                </div>
@endif


                <hr>

                <!-- Posted Comments -->
@if(@comments)

    @foreach($comments as $comment)
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img height="64" class="media-object" src="{{$comment->photo}}" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{$comment->author}}
                            <small>{{$comment->created_at->diffForHumans()}}</small>
                        </h4>
                        {{$comment->body}}


                        @if($comment->replies)

                            @foreach($comment->replies as $reply)
                                <!--  Nested Comment -->
                                <div id="nested-comment" class="media">
                                    <a class="pull-left" href="#">
                                        <img height="64" class="media-object" src="{{$reply->photo}}" alt="">
                                    </a>
                                    
                                        <div class="media-body">
                                        <h4 class="media-heading">
                                            {{$reply->author}}
                                            <small>{{$reply->created_at->diffForHumans()}}</small>
                                            
                                        </h4>
                                      {{$reply->body}}
                                    </div>
                                     {!! Form::open(['method'=>'POST', 'action' => 'CommentRepliesController@createReply']) !!}
                             <input type="hidden" value="{{$comment->id}}" name="comment_id">

                             <div class="form-group">

                              {!! Form::label('body','Body:') !!}
                              {!! Form::textarea('body',null,['class'=>'form-control','rows'=>1]) !!}
                              
                             </div> 
                             <div class="form-group">

                              {!! Form::submit('Submit',['class' => 'btn btn-primary']) !!}
                              
                             </div>

                             {!! Form::close() !!}
                                </div>

                            @endforeach
                        @endif
                        </div>
                    </div>

    @endforeach
@endif
 
@stop