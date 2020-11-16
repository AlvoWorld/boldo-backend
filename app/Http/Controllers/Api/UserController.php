<?php
   
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Pending;
use App\Models\Recipe;
use App\Traits\ImageOperation;
use DB;
class UserController extends Controller
{
    use ImageOperation;

    public function __construct()
    {
    }

    public function register(Request $request){

        // $photo = $request->photo64;
        $name = $request->name;
        $email = $request->email;
        $bio = $request->bio;
        $references = $request->references;
        $styleOfCooking = $request->styleOfCooking;
        $liquorServingCertification = $request->liquorServingCertification;
        $company = $request->company;
        $title = $request->title;
        $years = $request->years;
        $location = $request->location;
        $typeOfProfessional = $request->typeOfProfessional;
        $password = $request->password;
        $professional = $request->professional;

        $image=$this->uploadImage($request->get('photo64'),"logo", "user");

        if(User::where('email', $email)->count() > 0)
            return response()->json([
                'success'=>true, 
                "data"=>"exists"
            ], 200);
        
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->bio = $bio;
        $user->references = $references;
        $user->styleOfCooking = $styleOfCooking;
        $user->liquorServingCertification = $liquorServingCertification;
        $user->company = $company;
        $user->title = $title;
        $user->years = $years;
        $user->location = $location;
        $user->typeOfProfessional = $typeOfProfessional;
        $user->password = bcrypt($password);
        $user->role = $professional;
        $user->photo = url("/uploads/logo/".$image);
        $user->save();

        return response()->json([
            'success'=>true, 
            "data"=>''
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
        ], 401);
    }

    public function uploadPost(Request $request){
        $id = $request->input('id');
        $image=$this->uploadImage($request->get('photo64'),"post", "post");
        $image = url("/uploads/post/".$image);
        $post = Post::create(['user_id' => $id , 'photo' => $image]);
        return response()->json([
            'success'=>true,
            'data'=>$post 
        ]);
    }

    public function getPosts(Request $request){
        $id = $request->input('id');
        $posts = Post::orderBy('id')->get();
        foreach($posts as $post){
            $post->user;
        }
        return response()->json([
            'success'=>true,
            'data'=>$posts,
        ]);
    }

    public function getPros(Request $request){
        $user = User::find($request->input('id'));
        $pendings = $user->pending;
        $users = User::where('role', 1)->where('id', '!=', $request->input('id'))->orderBy('id')->get();
        $filteredUsers = array();
        foreach($users as $user){
            $bExist = false;
            foreach($pendings as $pending){
                if($pending->connect_id == $user->id)
                    $bExist = true;
            }

            if(!$bExist)
                array_push($filteredUsers, $user);
        }

        return response()->json([
            'success'=>true,
            'data'=>$filteredUsers,
        ]);
    }

    public function sendConnect(Request $request){
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $pending = Pending::create(['user_id' => $id , 'connect_id'=>$user_id, 'state'=>0]);
        return response()->json([
            'success'=>true,
            'pending'=>$pending
        ]);
    }

    public function getPendings(Request $request){
        $id = $request->input('id');
        $pendings = Pending::where([['user_id',  $id], ['state', 0]])->get();
        foreach($pendings as $pending){
            $pending->userPending;
        }
        return response()->json([
            'success'=>true,
            'pendings'=>$pendings
        ]);
    }

    public function uploadRecipe(Request $request){
        $id = $request->input('id');
        $title = $request->input('title');
        $content = $request->input('content');

        $recipe = new Recipe;
        $recipe->user_id = $id;
        $recipe->title = $title;
        $recipe->content = $content;
        $image=$this->uploadImage($request->get('photo64'),"recipe", "recipe");
        $image = url("/uploads/recipe/".$image);
        $recipe->photo = $image;
        $recipe->save();

        return response()->json([
            'success'=>true,
        ]);
    }

    public function getRecipes(Request $request){
        $recipes = Recipe::get();
        return response()->json([
            'success'=>true,
            'data'=>$recipes
        ]);
    }
    
    public function getUserInfo(Request $request){

        $id = $request->input('id');

        $posts = Post::where('user_id', $id)->orderBy('id')->get();
        $connections = Pending::where([['user_id', $id], ['state', 1]])->orderBy('id')->get();

        foreach($connections as $connection){
            $connection->userPending;
        }

        return response()->json([
            'success'=>true,
            'posts'=>$posts,
            'users'=>$connections,
        ]);
    }
}