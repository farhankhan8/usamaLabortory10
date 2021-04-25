<?php

namespace App\Http\Controllers;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\StoreTestPerformedRequest;
use DB;
use App\AvailableTest;
use App\Patient;
use App\TestPerformed;


use App\Http\Requests\UpdateEventRequest;
use App\Room;
// use App\AvailableTest;
use App\AvailableTestPatient;
use App\Test;
use App\Status;
use App\Tag;
use App\Artical;
use Session;


use App\Catagory;
use App\Services\EventService;
// use App\Patient;
use App\Ahmed;
use App\Role1;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestsPerformedController extends Controller
{
    // $a = Artical::first();
    // $b= $a->tags;
    // dd($b);
    public function index()
    {
        // foreach (AvailableTestPatient::lazy() as $flight) {
        //     print_r($flight);
        // }
         $a = Patient::get();
        $b = Patient::find(1);
        $c = $b->available_test_patients;
        // $e = Patient::find(1);

    //    $f = $e->available_tests;
    //     $b = $c->available_test_patients;
        // dd($b);
        // $b = AvailableTest::distinct()->get();
        //  $c = Patient::distinct()->get();
        
        //  $c = $b->patient;

        
        // $a = AvailableTest::get();
        // $a = AvailableTest::with('patient')->get();
        // $a = Patient::get();


        // dd($a);
        // $b = AvailableTestPatient::get();


// return view('user.index', compact('users'));
//         $role = Role1::find(1);	
 
// dd($role->users);
//         $user = Ahmed::find(1);	
 
// dd($user->roles);
        //  abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $events= AvailableTestPatient::orderBy('created_at','desc')->get();

        // $events = AvailableTest::find(1);
        // $pat = Patient::find(1);
        // $b = $pat->availableTest;
        // $availPatient = AvailableTestPatient::find(1);

        // $a = $events->patient;


        return view('admin.TestPerformed.index', compact('a','c'));
    }

    public function create()
    {
        //  abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = Patient::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $availableTests = AvailableTest::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        //  $sta = Status::all()->pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');
        //  dd($sta);

        // $sta = Status::get();


        // $rooms = Catagory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $availableTests = AvailableTest::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');


        // $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.TestPerformed.create', compact('users','availableTests'));
    }

    public function store(Request $request)
    {
        
        $input = $request->all();
        AvailableTestPatient::create($input);
        // $results = Table::latest('datetime')->first();

        // $artica = Artical::latest('name');
        // $ta = Tag::latest();
        // $artica->tags()->attach($ta);
       
        return redirect()->route('tests-performed');




    }
    // public function store(StoreEventRequest $request, EventService $eventService)
    // {
    //     if ($eventService->isRoomTaken($request->all())) {
    //         return redirect()->back()
    //                 ->withInput($request->input())
    //                 ->withErrors('This room is not available at the time you have chosen');
    //     }

    //     $event = Event::create($request->all());

    //     if ($request->filled('recurring_until')) {
    //         $eventService->createRecurringEvents($request->all());
    //     }

    //     return redirect()->route('admin.events.index');

    // }

    public function edit($id)
    {
             abort_if(Gate::denies('room_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event  = AvailableTestPatient::findOrFail($id);
        $users = Patient::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $rooms = AvailableTest::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');


        // abort_if(Gate::denies('room_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.TestPerformed.edit', compact('event','rooms','users'));
    }
    // public function edit(Event $event)
    // {
    //     abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $rooms = Room::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

    //     $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

    //     $event->load('room', 'user');

    //     return view('admin.events.edit', compact('rooms', 'users', 'event'));
    // }

    public function update($id, Request $request)
    {
        $task = AvailableTestPatient::findOrFail($id);

        // $this->validate($request, [
        //     'title' => 'required',
        //     'description' => 'required'
        // ]);
    
        $input = $request->all();
    
        $task->fill($input)->save();
    
        Session::flash('flash_message', 'Task successfully added!');
    
        return redirect()->route('tests-performed');
        // $event->update($request->all());

        // return redirect()->route('admin.events.index');

    }
    public function show($id)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = AvailableTestPatient::findOrFail($id);
        $roo = AvailableTest::findOrFail($id);
        $a = $roo->patient->pluck('name');
        // dd($rooms);

        return view('admin.TestPerformed.show', compact('rooms','roo','a'));
    }

    // public function show(Event $event)
    // {
    //     abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     $event->load('room', 'user');

    //     return view('admin.events.show', compact('event'));
    // }

    public function destroy($id)
    {
        $task = AvailableTestPatient::findOrFail($id);
    
        $task->delete();
    
        Session::flash('flash_message', 'Task successfully deleted!');
    
        return redirect()->route('tests-performed');

    }

    public function massDestroy(MassDestroyEventRequest $request)
    {
        Event::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
