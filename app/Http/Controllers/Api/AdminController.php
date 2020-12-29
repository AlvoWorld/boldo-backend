<?php
   
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Pending;
use App\Models\History;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\Report;
use App\Traits\ImageOperation;
use DB;
use App\Traits\CommonHelper;

class AdminController extends Controller
{
    use ImageOperation;
    use CommonHelper;

    public function __construct()
    {
    }

    public function register(Request $request){
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        if(User::where('email', $email)->count() > 0)
            return response()->json([
                'success'=>false, 
            ], 200);
        
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->role = 2;
        $user->password = bcrypt($password);
        $user->save();
        return response()->json([
            'success'=>true, 
        ], 200);
    }

    public function login(Request $request){
        $email = $request->email;
        $password = $request->password;
        $token = "";
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken($user->id)->accessToken;
            $success['user'] =  $user;
            
            return response()->json([
                'success'=>true, 
                "data" => $success, 
                'message'=>"login success"
            ]);
        }
        return response()->json([
            'success'=>false, 
            'message'=>'Unauthorised'
        ]);
    }

    public function getUsers(Request $request){
        $users = User::where('role', '!=', 2)->get();
        return response()->json([
            'success'=>true, 
            'data'=>$users
        ]);
    }

    public function removeUser(Request $request){
        $user_id = $request->user_id;
        $user = User::find($user_id);

        $pendings = $user->pending;
        foreach($pendings as $pending){
            $pending->chatroom()->delete();
        }
        $pendingUsers = $user->pendingUser;
        foreach($pendingUsers as $pendingUser){
            $pendingUser->chatroom()->delete();
        }
        $user->histories()->delete();
        $user->pendingUser()->delete();
        $user->pending()->delete();
        $user->receipe()->delete();
        $user->post()->delete();

        $user->delete();
        return response()->json([
            'success'=>true, 
        ]);
    }

    public function activeUser(Request $request){
        $user_id = $request->user_id;
        $user = User::find($user_id);
        $user->active = !$user->active;
        $user->save();
        return response()->json([
            'success'=>true, 
            'data'=>$user
        ]);
    }

    public function getPosts(Request $request){
        $posts = Post::orderBy('id')->get();
        foreach($posts as $post){
            $post->user;
        }
        return response()->json([
            'success'=>true,
            'data'=>$posts,
        ]);
    }

    public function removePost(Request $request){
        $post_id = $request->post_id;
        $post = Post::find($post_id)->delete();
        return response()->json([
            'success'=>true, 
        ]);
    }

    public function activePost(Request $request){
        $post_id = $request->post_id;
        $post = Post::find($post_id);
        $post->active = !$post->active;
        $post->save();
        return response()->json([
            'success'=>true, 
            'data'=>$post
        ]);
    }

    public function getRecipes(Request $request){
        $receipes = Recipe::get();
        foreach($receipes as $receipe){
            $receipe->user;
        }
        return response()->json([
            'success'=>true, 
            'data'=>$receipes
        ]);
    }

    public function removeRecipe(Request $request){
        $recipe_id = $request->recipe_id;
        $recipe = Recipe::find($recipe_id)->delete();
        return response()->json([
            'success'=>true, 
        ]);
    }

    public function activeRecipe(Request $request){
        $recipe_id = $request->recipe_id;
        $recipe = Recipe::find($recipe_id);
        $recipe->active = !$recipe->active;
        $recipe->save();
        return response()->json([
            'success'=>true, 
            'data'=>$recipe
        ]);
    }
}