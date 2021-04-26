<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;
use App\Models\Shift;
use \Carbon\CarbonPeriod;


use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
public function attend(Request $request,$id){
    //everyday
//attend
$post=Post::find($id);
if ($post->time_in!=Null){

    $dt = Carbon::now();
    $dt->toTimeString();
    $dt->toDateString();
    $post = new Post([
        'user_id' => auth()->user()->id,
        'time_in' => $dt->toTimeString(),
        'date' => $dt->toDateString(),
       
    ]);

    $post->save();

    // return redirect('/home')->with('success', 'تم الإرسال بنجاح');
 }
//leave
//  elseif($post->time_in!=Null && $post->time_out=Null){
  
//     $tout= Carbon::now();
//     $post->time_out = $tout->toTimeString();

//     $post->save();

// //     return redirect('/home')->with('success', 'تم التعديل بنجاح');
//  }
// //absent
// else{}

 }
  public function leavattend($id){
    $post=Post::find($id);
         $tout= Carbon::now();
         $post->time_out = $tout->toTimeString();
    
         $post->save();
  }



  public function store(){

    if(Auth::user()->passedLimit()){
        dd(Auth::user()->passedLimit());
      }
    $dt = Carbon::now();
    $dt->toTimeString();
    $dt->toDateString();
    $post = new Post([
        'user_id' => auth()->user()->id,
        'time_in' => $dt->toTimeString(),
        'date' => $dt->toDateString(),
       
    ]);


 
    $post->save();
    return redirect('/home')->with('success', 'تم الإرسال بنجاح');

  }

  public function edit($id){
  $post=Post::find($id);
  $user= User::all();
  return view('user.home',['post'=> $post]);

  }

  public function update(){
     
        $dt = Carbon::now();
         $post = Auth::user()->posts->where('date',$dt->toDateString())->where('time_out',null)->first();

  
      if(Auth::user()->passedLimit()){
        dd(Auth::user()->passedLimit());
      }
     
    //   if(){
    //     return redirect()->route('user.home')->withMessage('You have already left 3 times');
    //   }
    $tout= Carbon::now();
     $post->time_out = $tout->toTimeString();

     $post->save();
     return redirect()->route('user.home');
  }


  public function calc(){//recived input
      $attend=0;
      $leave=0;
  
      $user=Auth::user()->id;
      $from='2021-04-1'; //input
      $to='2021-04-30'; //input
      $day=$from;
      $totalLate=0;
      $period = CarbonPeriod::create($from,$to);
 
      // Iterate over the period
      foreach ($period as $day) {
  

        $postfirst=Post::where('user_id',$user)->where('date',$day)->first(); //return non object
        $postlast=Post::where('user_id',$user)->where('date',$day)->latest()->first();

        if($postfirst!=null){
          $late=0;
          $late2=0;
          $workStart= Carbon::parse($postfirst->date.' 08:00:00'); //consider shift table !
          $workEnds= Carbon::parse($postlast->date.' 16:00:00');// consider shift table !

         $attend=Carbon::parse($postfirst->date.' '.$postfirst->time_in);
         $earlyGo=Carbon::parse($postlast->date.' '.$postlast->time_out);
         $workStart= Carbon::parse($postfirst->date.' 08:00:00'); //consider shift table !
         $workEnds= Carbon::parse($postlast->date.' 16:00:00');// consider shift table !
         
         $flixbalMinutes=Carbon::parse($postfirst->date.' 08:10:00');
         //late grater than 8:10:00

          if($attend->greaterThan($flixbalMinutes)){
           $late=$attend->diffInMinutes($workStart);
          }
          //early out
          if($earlyGo->lessThan($workEnds)){
           $late2=$earlyGo->diffInMinutes($workEnds);
            
          } 
          
        }
        if(($postfirst!=null) && ( $late!=0 || $late2!=0)){ //sum
        $totalLate=$late+$late2+$totalLate;}
      }
      
      dd($totalLate,$late,$late2);

   
     return $totalLate;
  
  }


  public function extraTime(){
     $user=Auth::user()->id;
      //$today= Carbon::now();
      $from=Carbon::parse('2021-04-1'); //input
      $to=Carbon::parse('2021-04-30'); //input
      //$day=$from;
      $extraTime=0;
      $total=0;

      for( $day=$from; $day>=$from && $day<=$to; $day->addDays(1)->toDateString()){
        $postlast=Post::where('user_id',$user)->where('date',$day)->orderBy('id', 'desc')->first();


              if($postlast!=null){
              
                $workEnds= Carbon::parse($postlast->date.' 16:00:00');// consider shift table !
                $time_out=Carbon::parse($postlast->date.' '.$postlast->time_out); //employee out

                    if($time_out->greaterThan($workEnds)){
                    $extraTime=$time_out->diffInMinutes($workEnds);
                    
                        }
              }   
              $total=$total+$extraTime;
             
                    }//end for

    
      while($day>=$from && $day<=$to){
        $postlast=Post::where('user_id',$user)->where('date',$day)->orderBy('id', 'desc')->first();
       

        if($postlast!=null){
        
          $workEnds= Carbon::parse($postlast->date.' 16:00:00');// consider shift table !
          $time_out=Carbon::parse($postlast->date.' '.$postlast->time_out); //employee out

              if($time_out->greaterThan($workEnds)){
              $extraTime=$time_out->diffInMinutes($workEnds);
                  }
        }//end if
         $total=$total+$extraTime;
          $day=$day->addDays(1);
          $day=$day->toDateString(); 
          
      }// end while

 
     dd($total);
  }//end of extraTime function

}
