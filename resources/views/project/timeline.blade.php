            @foreach($getlog as $get) 
              <div class="box-footer box-comments" @if($get->revisi==2) style="background:#fdb6b6" @endif>
                <div class="box-comment">
                  <img class="img-circle img-sm" src="{{url_plug()}}/img/akun_log.png" alt="User Image">

                  <div class="comment-text">
                        <span class="username">
                          {{$get->name}} ({{$get->role}})
                          <span class="text-muted pull-right">{{$get->created_at}}</span>
                        </span>
                        <span class="username" style="color:{{$get->color}}">
                        @if($get->revisi==2) <font color="#000">Revisi kembali ke status</font> @endif {{$get->status}}
                        </span>
                        {{$get->deskripsi}}
                  </div>
                </div>
                
              </div>
            @endforeach