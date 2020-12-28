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
use App\Models\Type;
use App\Models\CookingStyle;
use App\Traits\ImageOperation;
use DB;
use App\Traits\CommonHelper;

class UserController extends Controller
{
    use ImageOperation;
    use CommonHelper;


    public function __construct()
    {
    }

    public function signOut(Type $var = null){
        $id = $request->input('id');
        $user = User::find($id);
        $user->device_token =NULL;
        $user->save();
        return response()->json([
            'success'=>true, 
        ]);
    }

    public function updateToken(Request $request){
        $id = $request->input('id');
        $device_token = $request->input('token');

        $user = User::find($id);
        $user->device_token = $device_token;
        $user->save();

        return response()->json([
            'success'=>true, 
        ]);
    }

    public function getFrontDatas(Type $var = null){
        $types = Type::select('id', 'name')->orderBy('sort')->get();
        $styles = CookingStyle::select('id', 'name')->orderBy('sort')->get();
        return response()->json([
            'success'=>true, 
            "types"=>$types,
            "styles"=>$styles
        ], 200);
    }

    public function register(Request $request){

        // $photo = $request->photo64;
        $fname = $request->fname;
        $lname = $request->lname;
        $email = $request->email;
        $bio = $request->bio;
        $references = $request->references;
        $styleOfCooking = $request->styleOfCooking;
        $liquorServingCertification = $request->liquorServingCertification;
        $company = $request->company;
        $title = $request->title;
        $years = $request->years;
        $location = $request->location;
        $postalCode = $request->postalCode;
        $typeOfProfessional = $request->typeOfProfessional;
        $password = $request->password;
        $professional = $request->professional;
        $histories = $request->histories;

        if(User::where('email', $email)->count() > 0)
        return response()->json([
            'success'=>true, 
            "data"=>"exists"
        ], 200);
        
        $user = new User;
        $user->fname = $fname;
        $user->lname = $lname;
        $user->email = $email;
        $user->bio = $bio;
        $user->references = $references;
        $user->styleOfCooking = $styleOfCooking;
        $user->liquorServingCertification = $liquorServingCertification;
        $user->company = '';
        $user->title = '';
        $user->years = '';
        $user->location = $location;
        $user->password = bcrypt($password);
        $user->role = $professional;
        if($professional)
            $user->typeOfProfessional = $typeOfProfessional;
        $user->postalCode = $postalCode;
        if($request->get('photo64') != ""){
            $image=$this->uploadImage($request->get('photo64'),"logo", "user");
            $user->photo = url("/uploads/logo/".$image);
        }else{
            $user->photo = url("/uploads/logo/default.png");
        }
       
        $user->save();
        for($i = 0; $i < count($histories); $i ++){
            $history = $histories[$i];
            $history['user_id'] = $user->id;
            History::create($history);
        }
        return response()->json([
            'success'=>true, 
            "data"=>''
        ], 200);
    }

    public function updateProfile(Request $request){
        $id = $request->id;
        $all = $request->all();
        $user = User::find($id);
        if($request->get('photo') != ""){
            $image=$this->uploadImage($request->get('photo'),"logo", "user");
            $all['photo'] = url("/uploads/logo/".$image);
        }else{
            $all['photo'] = url("/uploads/logo/default.png");
        }

        $user->update($all);
        History::where('user_id', $user->id)->delete();

        foreach($all['histories'] as $history){
            $history['user_id'] = $user->id;
            History::create($history);
        }
        return response()->json([
            'success'=>true,
            'data'=>$all
        ]);
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
        $post = Post::create(['user_id' => $id , 'photo' => $image, 'content' =>$request->input('content')]);
        return response()->json([
            'success'=>true,
            'data'=>$post 
        ]);
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

    public function getPosts(Request $request){
        $id = $request->input('id');
        $posts = Post::where('active', true)->orderBy('id')->get();
        foreach($posts as $post){
            $post->user;
            $post['user']['typeOfProfessional'] = $this->getTypeNamesFromIds($post['user']['typeOfProfessional']);
        }
        return response()->json([
            'success'=>true,
            'data'=>$posts,
        ]);
    }

    public function getPros(Request $request){
        $user = User::find($request->input('id'));
        $pendings = Pending::where('user_id', $user->id)->orWhere('connect_id', $user->id)->get();
        $users = User::where('role', 1)->where('id', '!=', $request->input('id'))->where('active', true)->orderBy('id')->get();
        $filteredUsers = array();
        foreach($users as $user){
            $bExist = false;
            foreach($pendings as $pending){
                if($pending->connect_id == $user->id)
                    $bExist = true;
                else if($pending->user_id == $user->id)
                    $bExist = true;
            }

            if(!$bExist){
                $user['typeOfProfessionalNames'] = $this->getTypeNamesFromIds($user->typeOfProfessional);
                $user['styleOfCookingNames'] = $this->getStyleNamesFromIds($user->styleOfCooking);
                array_push($filteredUsers, $user);
            }
        }

        return response()->json([
            'success'=>true,
            'data'=>$filteredUsers,
        ]);
    }

    public function sendConnect(Request $request){
        $id = $request->input('id');
        $send_user = User::find($id);
        $user_id = $request->input('user_id');
        $pending = Pending::create(['user_id' => $id , 'connect_id'=>$user_id, 'state'=>0]);

        $user = User::find($user_id);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $device_token = $user->device_token;

        $notification = array(
            'title' => "New Connection Comming", 
            'text' => "You received connection from ".$send_user->name
        );

        $fields = array(
            'to' => $device_token,
            'notification' => $notification
        );

        $headers = array(
            'Authorization: key=AAAABAbSFZE:APA91bFbaD0aAG-aoYadiJ41qzwenSFU2RnXF3wcFZ63Lx2rPxywCpp8KGlWVG8nL-pEAbxCaFcHxO_jjciWIlT0-9Y8Q5yKuJvy1YItJPR7b1jl1vy_FugPF_3Zpw5lX-Tn9QtqWpgH',
            'Content-type: Application/json'
        );

        $this->sendCurlRequest($url,'post',json_encode($fields),$headers);


        return response()->json([
            'success'=>true,
            'pending'=>$pending
        ]);
    }

    public function getPendings(Request $request){
        $id = $request->input('id');
        $pendings = Pending::where([['user_id',  $id], ['state', 0]])
        ->get();
        foreach($pendings as $pending){
            $pending->userPending;
            $pending['userPending']['typeOfProfessional'] = $this->getTypeNamesFromIds($pending['userPending']['typeOfProfessional']);
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
        $recipes = Recipe::where('active', true)->orderBy('count', 'desc')->orderBy('id', 'desc')->get();
        foreach($recipes as $recipe){
            $recipe->reviews;
        }
        return response()->json([
            'success'=>true,
            'data'=>$recipes
        ]);
    }

    public function viewRecipe(Request $request){
        $form = $request->all();
        $count = 1;
        if(Review::where(['recipe_id' => $form['recipe_id'], 'user_id' => $form['user_id']])->get()->count() == 0){
            $recipe = Recipe::find($form['recipe_id']);
            if(!is_null($recipe->count))
                $count =  $recipe->count + 1;
            $recipe->count = $count;
            $recipe->save();
        }
        $review = Review::updateOrCreate(['recipe_id' => $form['recipe_id'], 'user_id' => $form['user_id']], $form);
        return response()->json([
            'success'=>true,
            'data'=>$review
        ]);
    }
    
    public function getUserInfo(Request $request){

        $id = $request->input('id');
        $posts = Post::where('user_id', $id)->orderBy('id')->get();
        $connections = Pending::where('state', 1)
                                ->orderBy('id')->get();

        $data = array();
        foreach($connections as $connection){
           if($connection->user_id == $id){
               $user = User::find($connection->connect_id);
           }else{
            $user = User::find($connection->user_id);
           }
           if($connection->user_id == $id || $connection->connect_id == $id){
               $connection->user = $user;
               $connection['user']['typeOfProfessional'] = $this->getTypeNamesFromIds($connection['user']['typeOfProfessional']);
               array_push($data, $connection);
           }

        }

        return response()->json([
            'success'=>true,
            'posts'=>$posts,
            'users'=>$data,
        ]);
    }

    public function removePending(Request $request){
        $id = $request->input('id');

        $pending = Pending::find($id);
        $send_user = User::find($pending->user_id);
        $connect_user = User::find($pending->connect_id);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $device_token = $connect_user->device_token;

        $notification = array(
            'title' => "Connection canceled", 
            'text' => "Your connection canceled by ".$send_user->name
        );

        $fields = array(
            'to' => $device_token,
            'notification' => $notification
        );

        $headers = array(
            'Authorization: key=AAAABAbSFZE:APA91bFbaD0aAG-aoYadiJ41qzwenSFU2RnXF3wcFZ63Lx2rPxywCpp8KGlWVG8nL-pEAbxCaFcHxO_jjciWIlT0-9Y8Q5yKuJvy1YItJPR7b1jl1vy_FugPF_3Zpw5lX-Tn9QtqWpgH',
            'Content-type: Application/json'
        );

        $this->sendCurlRequest($url,'post',json_encode($fields),$headers);
        $pending->delete();
        return response()->json([
            'success'=>true,
        ]);
    }

    public function applyPending(Request $request){
        $id = $request->input('id');

        $pending = Pending::find($id);
        $pending->state = 1;
        $pending->save();

        $send_user = User::find($pending->user_id);
        $connect_user = User::find($pending->connect_id);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $device_token = $send_user->device_token;

        $notification = array(
            'title' => "Connection Accepted", 
            'text' => "Your connection accepted by ".$connect_user->name
        );

        $fields = array(
            'to' => $device_token,
            'notification' => $notification
        );

        $headers = array(
            'Authorization: key=AAAABAbSFZE:APA91bFbaD0aAG-aoYadiJ41qzwenSFU2RnXF3wcFZ63Lx2rPxywCpp8KGlWVG8nL-pEAbxCaFcHxO_jjciWIlT0-9Y8Q5yKuJvy1YItJPR7b1jl1vy_FugPF_3Zpw5lX-Tn9QtqWpgH',
            'Content-type: Application/json'
        );

        $this->sendCurlRequest($url,'post',json_encode($fields),$headers);
        return response()->json([
            'success'=>true,
        ]);
    }

    public function getBadge(Request $request){
        $id = $request->input('id');
        $badge = Pending::where(['connect_id'=> $id, 'state'=>0])->count();
        return response()->json([
            'success'=>true,
            'badge'=>$badge
        ]);
    }

    public function getConnections(Request $request){
        $id = $request->input('id');
        $users = Pending::where(['connect_id'=> $id, 'state'=>0])->get();
        foreach($users as $user){
            $user->user;
            $user['user']['typeOfProfessional'] = $this->getTypeNamesFromIds($user['user']['typeOfProfessional']);
        }
        return response()->json([
            'success'=>true,
            'users'=>$users
        ]);
    }

    public function getProfile(Request $request){
        $id = $request->id;
        $user = User::find($id);
        $user ->histories;

        return response()->json([
            'success'=>true,
            'data'=>$user
        ]);
    }

    public function sendReport(Request $request){
        
        return response()->json([
            'success'=>true,
            'data'=>''
        ]);
    }

    public function checkConnection(Request $request){
        $id = $request->id;
        $oposit_id = $request->oposit_id;
        $users = Pending::where(['user_id'=> $id, 'connect_id'=>$oposit_id, 'state'=>1])->get()->count();
        return response()->json([
            'success'=>true,
            'data'=>$users
        ]);
    }

    public function autoConnection(Request $request){
        $id = $request->id;
        $oposit_id = $request->oposit_id;

        $connections = Pending::where(['user_id'=> $id, 'connect_id'=>$oposit_id])->get()->count();

        if($connections > 0){
            $pending = Pending::where(['user_id'=> $id, 'connect_id'=>$oposit_id])->first();
        }else{
            $pending = new Pending;
        }

        $pending->user_id = $id;
        $pending->connect_id = $oposit_id;
        $pending->state = 1;
        $pending->save();
        return response()->json([
            'success'=>true,
            'data'=>''
        ]);
    }
}