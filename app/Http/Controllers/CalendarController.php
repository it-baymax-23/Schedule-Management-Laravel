<?php

namespace App\Http\Controllers;

use Auth;
use App\Calendar;
use App\Events;
use App\Utility;
use const http\Client\Curl\AUTH_ANY;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $currantWorkspace = Utility::getWorkspaceBySlug($slug);
        $events = Events::where('workspace','=',$currantWorkspace->id)->where('created_by','=',Auth::user()->id)->get();
        return view('calendar.index',compact('currantWorkspace','events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$slug)
    {
        $post =$request->all();
        if(isset($post['event_id'])){
            $event = Events::find($post['event_id']);
            $post['title'] = $event->title;
            $post['className'] = $event->className;
            if($post['remove_event']){
                $event->delete();
            }
            unset($post['event_id']);
        }
        if(!$post['allDay'] && empty($post['end'])){
            $post['end'] = date('Y-m-d H:i:s',(strtotime($post['start'])+(2*60*60)));
        }
        $currantWorkspace = Utility::getWorkspaceBySlug($slug);
        $post['workspace'] = $currantWorkspace->id;
        $post['created_by'] = Auth::user()->id;
        return Calendar::create($post)->toJson();
    }

    public function eventStore(Request $request,$slug)
    {
        $post =$request->all();
        $currantWorkspace = Utility::getWorkspaceBySlug($slug);
        $post['workspace'] = $currantWorkspace->id;
        $post['created_by'] = Auth::user()->id;
        return Events::create($post)->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function getJson(Request $request,$slug)
    {
        $currantWorkspace = Utility::getWorkspaceBySlug($slug);
        $calendar = Calendar::where('workspace','=',$currantWorkspace->id)->where('created_by','=',Auth::user()->id)->where(function ($q) use($request){
            $q->where('start',">=",$request->start)->where('end',"<=",$request->end)->whereNotNull('end');
        })->orWhere(function ($q) use($request){
            $q->where('start',">=",$request->start)->where('start',"<=",$request->end)->whereNull('end');
        })->get();

        $return = [];
        foreach ($calendar as $row){
            $row['start'] = strtotime($row['start'])*1000;
            $row['end'] = ($row['end'])?strtotime($row['end'])*1000:false;
            $row['allDay'] = (bool)$row['allDay'];
            $row['className'] = "bg-".$row['className'];
            $return[] = $row;
        }
        return json_encode($return);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $calendar = Calendar::find($request->id);
        $calendar->title = $request->title;
        $calendar->save();
    }
    public function updateDate(Request $request)
    {
        $calendar = Calendar::find($request->id);
        $calendar->start = $request->start;
        $calendar->allDay = $request->allDay;
        if(empty($calendar->end) && $request->allDay == false ){
            $calendar->end =date('Y-m-d H:i:s',(strtotime($request->start)+(2*60*60)));
        }else{
            $calendar->end = $request->end;
        }
        $calendar->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Calendar::find($request->id)->delete();
    }
}
