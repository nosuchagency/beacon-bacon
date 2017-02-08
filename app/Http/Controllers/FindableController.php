<?php

namespace App\Http\Controllers;

use App\Findable;
use App\Http\Requests;
use Illuminate\Http\Request;
use Artisan;

class FindableController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $findables = Findable::all();
        return view('findable.index', compact('findables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('findable.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
           'identifier' => 'required|max:255|unique:findables',
        ]);

        $findable = Findable::create($request->except('custom_file'));

        $this->uploadFile($findable, $request);

        return redirect()->route('findables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $findable = Findable::findOrFail($id);
        return view('findable.show', compact('findable'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $findable = Findable::findOrFail($id);

        return view('findable.edit', compact('findable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'name' => 'required|max:255',
           'identifier' => 'required|max:255|unique:findables',
        ]);

        $findable = Findable::findOrFail($id);
        $findable->update($request->except('custom_file'));

        $this->uploadFile($findable, $request);

        return redirect()->route('findables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findable = Findable::findOrFail($id);
        $findable->delete();

        return redirect()->route('findables.index');
    }

    protected function uploadFile(Findable $findable, Request $request)
    {
        if (!$request->hasFile('custom_file')) {
            return;
        }

        $file = $request->file('custom_file');

        $fileName = $findable->identifier . 'Plugin.php';

        $destinationPath = storage_path() . '/app/files/findables/';

        if ($findable->custom_file && is_file($destinationPath . $findable->custom_file)) {
            unlink($destinationPath . $findable->custom_file);
        }

        $file->storeAs('files/findables/', $fileName);

        $findable->update([
            'custom_file' => $fileName,
        ]);

        $output = shell_exec('cd .. && composer dump-autoload -o 2>&1');
    }
}
