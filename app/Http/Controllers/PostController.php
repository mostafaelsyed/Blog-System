<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
class PostController extends Controller
{
    public function index(){
        $postFromDB=Post::all();
        return view('posts.index',['posts'=>$postFromDB ]);
    }

    public function show($postId)
    {

        $singlePostFromDB= Post::find($postId);//model object

        if(is_null($singlePostFromDB))
        {
            return to_route('posts.index');
        }

        return view('posts.show',['post'=> $singlePostFromDB]);
    }

    public function create(){
        $users=User::all();
        return view('posts.create',['users'=>$users]);
    }

    public function store()
    {
        request()->validate([
            'title'=> ['required','min:3'],
            'description'=> ['required ','min:6'],
            'post_creator'=>['required ','exists:users,id']
        ]);
        //1- get the user data
        $data = request()->all();
        $title = request()->title;
        $description = request()->description;
        $postcreator = request()->post_creator;
        //2-store the submited data in DB
        Post::create([
            'title'=> $title,
            'description'=>$description,
            'user_id'=>$postcreator
        ]);
        return to_route('posts.index');
    }
    public function edit(Post $post){
        $users = User::all();

       return view('posts.edit',['users'=>$users , 'post'=>$post]);
    }
    public function update($postId){
        request()->validate([
            'title'=> ['required','min:3'],
            'description'=> ['required ','min:6'],
            'post_creator'=>['required ','exists:users,id']
        ]);
        //1- get user data
        $data = request()->all();
        $title = request()->title;
        $description = request()->description;
        $postcreator = request()->post_creator;

        //2- update the submitted data in database
          //(1)-select find the post
          $singlePostFromDB= Post::find($postId);
         //(2)-update the post data
        $singlePostFromDB->update([
            'title'=>$title,
            'description'=>$description,
            'user_id'=>$postcreator
        ]);
        return to_route('posts.show',$postId);
    }
    public function destroy($postId){
        //1-select or find the post
        $singlePostFromDB= Post::find($postId);
        //2-delete the post from database
        $singlePostFromDB->delete();
        //2-redirect to posts.index
        return to_route('posts.index');
    }
}
