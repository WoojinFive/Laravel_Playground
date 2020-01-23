<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\Theme;
use Carbon\Carbon;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'cookie', 'postCookie', 'ajax']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param CookieJar $cookieJar
     * @param Request $request
     * @param Response $response
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // get all post data
        $posts = DB::table('posts')
            ->select('posts.*', 'users.name')
            ->where('posts.deleted_at', '=', null)
            ->join('users','users.id','=','posts.user_id')
            ->orderBy('posts.created_at','DESC')
            ->orderBy('posts.title','ASC')
            ->get();

        if($request->cookie('theme'))
        {
            $selectedId = $request->cookie('theme');
        } else
        {
            $selectedId = Theme::where('is_default', true)->first()->id;
        }

        $themes = Theme::orderBy('id')->get();

        return view('posts.index', compact('posts', 'themes', 'selectedId'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->cookie('theme'))
        {
            $selectedId = $request->cookie('theme');
        } else
        {
            $selectedId = Theme::where('is_default', true)->first()->id;
        }

        $themes = Theme::orderBy('id')->get();


        return view('posts.create', compact('themes', 'selectedId'));
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
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:3', 'max:255'],
            'img_url' => ['required', 'string', 'url', 'max:255'],
        ]);


        $attributes['user_id'] = Auth::user()->id;
        $attributes['created_by'] = Auth::user()->id;

        $post = Post::create($attributes);

        if (count($post->getChanges()) == 0) {
            return redirect()->route('posts.index');
        }

        return redirect()->route('posts.index')
            ->with('success','Post Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
        if($request->cookie('theme'))
        {
            $selectedId = $request->cookie('theme');
        } else
        {
            $selectedId = Theme::where('is_default', true)->first()->id;
        }

        $themes = Theme::orderBy('id')->get();

        $post = DB::table('posts')
            ->select('posts.*', 'users.name')
            ->where('posts.id', '=', $post->id)
            ->join('users','users.id','=','posts.user_id')
            ->orderBy('posts.created_at','DESC')
            ->get()
            ->first();

        $names = DB::table('likes')->select('users.name')->where('likes.post_id', '=', $post->id)->where('likes.deleted_at', '=', null)->join('users', 'users.id', '=', 'likes.user_id')->pluck('name')->toArray();
        $comma_seperated_names = implode(", ", $names);

        $comments = DB::table('comments')
            ->select('comments.*', 'users.name')
            ->where('comments.post_id', '=', $post->id)
            ->where('comments.deleted_at', '=', null)
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('/posts/show', compact('post', 'themes', 'comma_seperated_names', 'comments', 'selectedId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
//        dd(DB::table('likes')
//            ->select('likes.*')
//            ->where('likes.user_id', '=', Auth::user()->id)
//            ->where('likes.post_id', '=', $post->id)
//            ->get()->count());
        $post_like = DB::table('likes')
                    ->select('likes.*')
                    ->where('likes.user_id', '=', Auth::user()->id)
                    ->where('likes.post_id', '=', $post->id);

//        dd($post_like->get()->first());
        if($post_like->get()->first() === null)
        {
            $attributes['user_id'] = Auth::user()->id;
            $attributes['post_id'] = $post->id;
            $attributes['created_by'] = Auth::user()->id;

//            dd($attributes);
            $like = Like::create($attributes);
        }
        else
        {
//            if($post_like->get()[0]->deleted_by != null)
//            {
//                DB::table('likes')
//                    ->select('likes.*')
//                    ->where('likes.user_id', '=', Auth::user()->id)
//                    ->where('likes.post_id', '=', $post->id)
//                    ->update(['deleted_by' => null, 'deleted_at' => null]);
//            }
//            else
//            {
            DB::table('likes')
                ->select('likes.*')
                ->where('likes.user_id', '=', Auth::user()->id)
                ->where('likes.post_id', '=', $post->id)->delete();
//                // update deleted_by
//                $post_like->deleted_by = Auth::user()->id;
//                $post_like->save();
//            }
        }


        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        // update deleted_by
        $post->deleted_by = Auth::user()->id;
        $post->save();
        return redirect()->route('posts.index')
            ->with('success','Post deleted successfully!');
    }

    public function cookie(Request $request)
    {
        $selectedId ='';
        if($request->theme)
        {
            // get selected ID
            $selectedId = $request->theme;
            Cookie::queue('theme', $selectedId, 5000);
        } else
        {
            //default theme id
            $selectedId = DB::table('themes')->where('is_default', '=', '1')->first()->id;

            Cookie::queue('theme', $selectedId, 5000);
        }

        $posts = DB::table('posts')
            ->select('posts.*', 'users.name')
            ->join('users','users.id','=','posts.user_id')
            ->orderBy('posts.created_at','DESC')
            ->orderBy('posts.title','ASC')
            ->get();

//         get all theme data

        $themes = Theme::orderBy('id')->get();

//        return redirect()->route('posts.index') -> with('posts', $posts) -> with('themes', $themes);
        return redirect()->back()->with('posts', $posts)->with('themes', $themes)->with('selectedId', $selectedId);
    }

    public function postCookie(Request $request)
    {
        if($request->theme)
        {
            // get selected ID
            $selectedId = $request->theme;
            Cookie::queue('theme', $selectedId, 500);
        } else
        {
            //default theme id
            $selectedId = DB::table('themes')->where('is_default', '=', '1')->first()->id;
            Cookie::queue('theme', $selectedId, 500);
        }

        $post = DB::table('posts')
            ->select('posts.*', 'users.name')
            ->where('posts.id', '=', $request->postId)
            ->join('users','users.id','=','posts.user_id')
            ->get()
            ->first();

//         get all theme data
        $themes = Theme::orderBy('id')->get();

        return redirect()->route('posts.show', ['id' => $request->postId]) -> with('post', $post) -> with('themes', $themes)->with('selectedId', $selectedId);
    }

    public function ajax(Request $request, Post $post)
    {
//        $current_timestamp = Carbon::now()->toDateTimeString();
//        $final_post_timestamp = Post::orderBy('created_at')->get()->last()->created_at;

        $timestamp = $request->timestamp;
//        $timestamp = Carbon::createFromTimestamp(strtotime($timestamp));
        $last_post = DB::table('posts')->where('deleted_at', '=', null)
            ->orderBy('created_at')->get()->last();
        $last_post_timestamp = Carbon::parse($last_post->created_at)->timestamp;

        if($last_post_timestamp >= $timestamp)
        {
            $postData['data'] = $last_post;
        }
        else
        {
            $postData['data'] = null;
        }

//        $postData['data'] = DB::table('posts')
//            ->where('deleted_at', '=', null)
//            ->where('created_at', '>=', $timestamp)
//            ->get();

        echo json_encode($postData);
        exit;
    }
}
