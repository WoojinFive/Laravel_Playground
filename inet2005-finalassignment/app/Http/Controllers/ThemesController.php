<?php

namespace App\Http\Controllers;

use App\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThemesController extends Controller
{
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
        $selectedRadio = "saved";

        $themes = DB::table('themes')
            ->select('themes.*')
            ->where('deleted_at', '=', null)
            ->get();

        return view('admin.themes.index', compact('themes', 'selectedRadio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.themes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:themes,name'],
            'cdn_url' => ['required', 'string', 'url', 'max:255', 'unique:themes,cdn_url']
        ]);

        //update modified values
        if($request->has('is_default'))
        {
            //reset previous default theme
            $current_theme = Theme::all()->where('is_default', '=', '1');
            $current_theme->first()->is_default = 0;
            $current_theme->first()->save();

            $attributes['is_default'] = 1;
            $theme = Theme::create($attributes);
        } else {
            $attributes['is_default'] = 0;
            $theme = Theme::create($attributes);
        }

        // update created_by
        $theme->created_by = Auth::user()->id;
        $theme->save();

        if (count($theme->getChanges()) == 0) {
            return redirect()->route('themes.index');
        }

        return redirect()->route('themes.index')
            ->with('success','Theme created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $theme)
    {
        return view('admin.themes.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function update(Theme $theme)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:themes,name,'.$theme->id.',id'],
            'cdn_url' => ['required', 'string', 'url', 'max:255', 'unique:themes,cdn_url,'.$theme->id.',id']
        ]);
        //update modified values
        if(request()->has('is_default'))
        {
            //reset previous default theme
            $current_theme = Theme::all()->where('is_default', '=', '1');
            $current_theme->first()->is_default = 0;
            $current_theme->first()->save();

            $attributes['is_default'] = 1;
            $theme->update($attributes);

            // update last_modified_by
            $theme->last_modified_by = Auth::user()->id;
            $theme->save();
        } else {
            $attributes['is_default'] = 0;
            $theme->update($attributes);

            //update default theme as first theme
            $new_theme = Theme::all()->first();
            $new_theme->is_default = 1;
            $new_theme->save();

            // update last_modified_by
            $theme->last_modified_by = Auth::user()->id;
            $theme->save();
        }

        if (count($theme->getChanges()) == 0) {
            return redirect()->route('themes.index');
        }

        return redirect()->route('themes.index')
            ->with('success','Theme updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $theme)
    {
        if($theme->is_default == 1) {
            return redirect()->route('themes.index')
                ->with('fail','Default theme cannot be deleted!');
        }

        $theme->delete();
        // update deleted_by
        $theme->deleted_by = Auth::user()->id;
        $theme->save();
        return redirect()->route('themes.index')
            ->with('success','Theme deleted successfully!');
    }

    public function filter(Request $request)
    {
        $selectedRadio = $request->radio;

        if($selectedRadio == 'saved')
        {
            $themes = DB::table('themes')
                ->select('themes.*')
                ->where('deleted_at', '=', null)
                ->get();

        } else if ($selectedRadio == 'deleted')
        {
            $themes = DB::table('themes')
                ->select('themes.*')
                ->where('deleted_at', '!=', null)
                ->get();
        }

        return view('admin.themes.index', compact('themes', 'selectedRadio'));
    }

    public function restore($id)
    {
        $theme = Theme::onlyTrashed()->find($id)->restore();

        $selectedRadio = "saved";

        $themes = DB::table('themes')
            ->select('themes.*')
            ->where('deleted_at', '=', null)
            ->get();

        return redirect()->route('themes.index');
    }
}
