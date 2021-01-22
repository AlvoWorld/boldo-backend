<?php
   
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\History;
use App\Models\Recipe;
use App\Models\Review;
use App\Models\Report;
use App\Models\Type;
use App\Models\Style;
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

    public function getData(Request $request){
        $types = Type::get()->count();
        $styles = Style::get()->count();
        $users = User::whereIn('role', [0, 1])->get()->count();
        $actived_users = User::whereIn('role', [0, 1])->where('active', true)->get()->count();
        $customers = User::where('role', 0)->get()->count();
        $actived_customers = User::where('role', 0)->where('active', true)->get()->count();
        $pros = User::where('role', 1)->get()->count();
        $actived_pros = User::where('role', 1)->where('active', true)->get()->count();
        $posts = Post::get()->count();
        $actived_posts = Post::get()->where('active', true)->count();
        $recipes = Recipe::get()->count();
        $actived_recipes = Recipe::get()->where('active', true)->count();
        $actived_recipes = Recipe::get()->where('active', true)->count();
        $reports = Report::get()->count();
        $new_reports = Report::get()->where('done', false)->count();
        return response()->json([
            'success'=>true, 
            'data'=>array('types' => $types, 'styles' => $styles, 'users' => $users, 'actived_users'=>$actived_users,
               'customers' => $customers, 'actived_customers' => $actived_customers, 'pros' => $pros, 'actived_pros' => $actived_pros, 
                'posts' => $posts, 'actived_posts'=>$actived_posts,'recipes' => $recipes, 'actived_recipes'=> $actived_recipes,
                'reports' => $reports, 'new_reports' => $new_reports,)
               
        ]);
    }

    public function getTypes(Request $request){
        $page = $request->page;
        $total = Type::orderBy('id')->get()->count();
        $types = Type::orderBy('id')
                ->skip(10*($page-1))
                ->take(10)
                ->get();
        $data['total'] = $total;
        $data['items'] = $types;
        return response()->json([
            'success'=>true, 
            'data'=> $data
        ]);
    }

    public function saveType(Request $request){
        $all = $request->all();
        $type = Type::updateOrCreate(['id' => $all['id']], $all);

        $notification = array(
            'title' => "New Professional Types Added", 
            'body' => "You received new type from admin"
        );

        $notificationData = array(
            "type" => 'new-type',
        );

        $this->sendNotificationToUsers($notification, $notificationData);
        return response()->json([
            'success'=>true, 
        ]);
    }

    public function deleteType(Request $request){
        $type_id = $request->input('id');

        $notification = array(
            'title' => "Professional Types Removed", 
            'body' => "Your received type removed signal from admin"
        );

        $notificationData = array(
            "type" => 'new-type',
        );
        Type::find($type_id)->delete();
        $users = User::whereIn('role', [0, 1])->get();
        foreach($users as $user){
            $typeOfProfessional = $user->typeOfProfessional;
            $typeOfProfessional = $this->removeValueFromArray($type_id, $typeOfProfessional);
            $user->typeOfProfessional = $typeOfProfessional;
            $user->save();
        }
        $this->sendNotificationToUsers($notification, $notificationData);
        return response()->json([
            'success'=>true, 
        ]);
    }

    

    public function getUsers(Request $request){
        $users = User::where('role', '!=', 2)->get();

        foreach($users as $user){
            $user->typeOfProfessional = $this->getTypeNamesFromIds($user->typeOfProfessional);
            $user->styleOfCooking = $this->getStyleNamesFromIds($user->styleOfCooking);
        }
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

    public function sendNotificationToUsers($notification, $notificationData)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $users = User::whereIn('role', [0, 1])->get();
        foreach($users as $user){
            $device_token = $user->device_token;
            if(!is_null($device_token)){
                $fields = array(
                    'to' => $device_token,
                    'notification' => $notification,
                    'data' => $notificationData
                );
    
                $headers = array(
                    'Authorization: key=AAAABAbSFZE:APA91bFbaD0aAG-aoYadiJ41qzwenSFU2RnXF3wcFZ63Lx2rPxywCpp8KGlWVG8nL-pEAbxCaFcHxO_jjciWIlT0-9Y8Q5yKuJvy1YItJPR7b1jl1vy_FugPF_3Zpw5lX-Tn9QtqWpgH',
                    'Content-type: Application/json'
                );
                $this->sendCurlRequest($url,'post',json_encode($fields),$headers);
            }
        }
    }

    public function removeValueFromArray($target, $array)
    {
        $result = array();
        foreach ($array as $value) {
            if($value != $target){
                array_push($result, $value);
            }
        }
        return $result;
    }

    public function getTypeNamesFromIds($ids){
        $data = array();
        foreach($ids as $id){
            $type = Type::find($id);
            array_push($data, $type->name);
        }
        return $data;
    }

    public function getStyleNamesFromIds($ids){
        $data = array();
        foreach($ids as $id){
            $type = CookingStyle::find($id);
            array_push($data, $type->name);
        }
        return $data;
    }

}