@extends('admin.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection
@section('content')
<div class="dashboard-main">
  @include('admin.layouts.navbar')
  <section class="middle-section">
    <div class="middle">
      <div class="middle-content">
        @if(session()->get('fail_msg'))
        <div class="row alert alert-danger text text-center">
            {{session()->get('fail_msg')}}
        </div>
        @elseif(session()->get('succ_msg'))
        <div class="row alert alert-success text text-center">
            {{session()->get('succ_msg')}}
        </div>
        @else
        @endif
        <div class="info-middle-content">
          <div class="tab-content">
              <div class="upload-sc d-flex">
                <div class="trash-left">
                  <div class="up-header">
                    <label>Notifications</label>
                    <label>&nbsp;</label>
                    <label>Time</label>
                  </div>
                  <div class="up-content notified">
                    <ul class="note-list">
                      <?php $i=1; $day12=''; ?>
                      @foreach($data['notifications'] as $recentnotification)
                      <?php if(date('Y-m-d')==date('Y-m-d',strtotime($recentnotification->created_at))){
                        $new_day = 'Today';
                        if($day12!=$new_day){
                          echo "<li><strong>".$new_day."</strong></li>";
                          $day12 = $new_day;
                        }
                      }elseif (date('Y-m-d',strtotime('-1 days'))==date('Y-m-d',strtotime($recentnotification->created_at))) {
                        $new_day = 'Yesterday';
                        if($day12!=$new_day){
                          echo "<li><strong>".$new_day."</strong></li>";
                          $day12 = $new_day;
                        }
                      }else{
                        $new_day = date('D d, F Y',strtotime($recentnotification->created_at));
                        if($day12!=$new_day){
                          echo "<li><strong>".$new_day."</strong></li>";
                          $day12 = $new_day;
                        }
                      } ?>
                      <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i2.png" alt=""/> {{$recentnotification->title}}
                        <span>
                          <?php
                            if($new_day=='Today'){
                              $time2 = date('Y-m-d h:i:s');
                              $time1 = strtotime($recentnotification->created_at);
                              $time2 = strtotime($time2);
                              $difference = ($time2 - $time1);
                              $min = (int) $difference;
                              if($min > (3600*24)){
                                  $time = $min/(3600*24);
                                  $day = (int)$time;
                                  echo $day.' Days ago';
                              }elseif($min > 3600){
                                  $time = $min/3600;
                                  $day = (int)$time;
                                  echo $day.' Hours ago';
                              }elseif($min > 60){
                                  $time = $min/60;
                                  $day = (int)$time;
                                  echo $day.' Min ago';
                              }else{
                                  echo $min.' Second ago';
                              }
                            }else{
                              echo date('h:i',strtotime($recentnotification->created_at));
                            }
                          $i++; ?>
                        </span></li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @include('admin.layouts.rightsection')
</div>
@include('admin.layouts.notificationmodal')

@endsection

@section('js')

@endsection

</body>
</html>