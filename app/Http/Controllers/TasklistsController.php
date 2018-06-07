<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Controllers\Controller;
use App\Tasklist;

class TasklistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
               
            ];
            $data += $this->counts($user);
            return view('tasklists.index', $data);
        }else {
            return view('welcome');
        }
    }
    
    public function create()
    {
        $tasklist = new Tasklist;

        return view('tasklists.create', [
            'tasklist' => $tasklist,
         ]);
    }

    
    public function store(Request $request)
    {
         $this->validate($request, [
            'content' => 'required|max:191',   // add
            'status' => 'required|max:10',
           
            
        ]);

        $tasklist = new Tasklist;
        $user = \Auth::user();
        $tasklist->user_id = $user->id;
        $tasklist->content = $request->content;    // add
        $tasklist->status = $request->status;
        $tasklist->save();
        //return "hello";
        return redirect('/');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     
    public function show($id)
    {
    $user = \Auth::user();
    $tasklists = Tasklist::where([['user_id', '=', $user->id],
                          ['id', '=', $id]]);
    if($tasklists->exists()) {
        return view('tasklists.show', [
            'tasklist' => $tasklists->first(),
        ]);
    } else {
        return redirect('/');
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $user = \Auth::user();
    $tasklists = Tasklist::where([['user_id', '=', $user->id],
                          ['id', '=', $id]]);
    if($tasklists->exists()) {
        return view('tasklists.edit', [
            'tasklist' => $tasklists->first(),
        ]);
    } else {
        return redirect('/');
    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
    
    public function update(Request $request, $id)
    
    {$this->validate($request, [
            'content' => 'required|max:191',   // add
            'status' => 'required|max:10',
            
        ]);

        $tasklist = Tasklist::find($id);
        $tasklist->content = $request->content;    // add
        $tasklist->status = $request->status;
        $tasklist->save();
        
        return redirect('/');
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = tasklist::find($id);
        $tasklist->delete();
        
        return redirect('/');
        
        $tasklist = \App\tasklist::find($id);

        if (\Auth::user()->id === $tasklist->user_id) {
            $tasklist->delete();
        }

        return redirect()->back();
    }
}
