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
use App\Models\Room;
use App\Models\Chat;
use App\Models\Type;
use App\Models\Style;
use App\Traits\ImageOperation;
use File;
use DB;
use App\Traits\CommonHelper;

class UserController extends Controller
{
    use ImageOperation;
    use CommonHelper;

    public function __construct()
    {
    }

    public function getTypsAndStyles(Type $var = null)
    {
        $types = Type::select('id', 'name', 'style')->orderBy('sort')->get();
        $styles = Style::select('id', 'name')->orderBy('sort')->get();
        return response()->json([
            'success'=>true,
            "types"=>$types,
            "styles"=>$styles
        ]);
    }

    public function register(Request $request)
    {
        $fname = $request->fname;
        $lname = $request->lname;
        if (is_null($lname)) {
            $lname = "";
        }
        $email = $request->email;
        $bio = $request->bio;
        $references = $request->references;
        $styleOfCooking = $request->styleOfCooking;
        $liquorServingCertification = $request->liquorServingCertification;
        $location = $request->location;
        $postalCode = $request->postalCode;
        $geolocation = $request->geolocation;
        $typeOfProfessional = $request->typeOfProfessional;
        $password = $request->password;
        $professional = $request->professional;
        $histories = $request->histories;

        if (User::where('email', $email)->count() > 0) {
            return response()->json([
                'success'=>true,
                "data"=>"exists"
            ], 200);
        }

        $user = new User;
        $user->fname = $fname;
        $user->lname = $lname;
        $user->email = $email;
        $user->bio = $bio;
        $user->references = $references;

        $user->liquorServingCertification = $liquorServingCertification;
        $user->company = '';
        $user->title = '';
        $user->years = '';
        $user->location = $location;
        $user->password = bcrypt($password);
        $user->role = $professional;
        $user->geolocation = $geolocation;

        if ($professional) {
            $user->typeOfProfessional = $typeOfProfessional;
            $user->styleOfCooking = $styleOfCooking;
        } else {
            $user->typeOfProfessional = array();
            $user->styleOfCooking = array();
        }

        $user->postalCode = $postalCode;
        if ($request->get('photo64') != "") {
            $image=$this->uploadImage($request->get('photo64'), "logo", "user");
            $user->photo = url("/uploads/logo/".$image);
        } else {
            $user->photo = url("/uploads/logo/default.png");
        }

        $user->save();
        if ($user->role == 1) {
            for ($i = 0; $i < count($histories); $i ++) {
                $history = $histories[$i];
                $history['user_id'] = $user->id;
                History::create($history);
            }
        }

        return response()->json([
            'success'=>true,
            "data"=>''
        ], 200);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $token = "";
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $user->histories;
            if ($user->active == false) {
                return response()->json([
                    'success'=>false,
                    'message'=>'You are not available for this app, please contact with admin.'
                ], 401);
            }
            if(!is_null($request->type) && $request->type == 'login'){
                DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
                $success['token'] =  $user->createToken($user->id)->accessToken;
            }
            $success['user'] =  $user;
            return response()->json([
                'success'=>true,
                "data" => $success,
                'message'=>"login success"
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>'Email or password is not correct.'
        ], 401);
    }

    public function getUserPosts(Request $request)
    {
        $id = $request->input('id');
        $posts = Post::where('user_id', $id)->orderBy('id', 'desc')->get();
        return response()->json([
            'success'=>true,
            'data'=>$posts,
        ]);
    }

    public function signOut(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        $user->device_token = null;
        $user->save();
        return response()->json([
            'success'=>true,
        ]);
    }

    public function getPosts(Request $request)
    {
        $posts = Post::where('active', true)->orderBy('id', 'desc')->get();
        foreach ($posts as $post) {
            $post->user->histories;
            $post['user']['typeOfProfessionalNames'] = $this->getTypeNamesFromIds($post['user']['typeOfProfessional']);
        }

        return response()->json([
            'success'=>true,
            'data'=>$posts,
        ]);
    }

    public function uploadPost(Request $request)
    {
        $id = $request->input('id');
        $image=$this->uploadImage($request->get('photo'), "post", "post");
        $image = url("/uploads/post/".$image);


        $post = Post::create(['user_id' => $id , 'photo' => $image, 'content' =>$request->input('content')]);

        // $notification = array(
        //     'title' => "New Post Received",
        //     'body' => "You received new post"
        // );

        // $notificationData = array(
        //     "type" => 'new-post',
        // );

        // $this->sendNotificationToUsers($notification, $notificationData);
        return response()->json([
            'success'=>true,
        ]);
    }

    public function deletePost(Request $request)
    {
        $id = $request->input('id');
        Post::find($id)->delete();
        Report::where('post_id', $id)->delete();
        return response()->json([
            'success'=>true,
            'data'=>''
        ]);
    }

    public function sendReport(Request $request)
    {
        $id = $request->id;
        $user_id = $request->user_id;
        $content = $request->reason;
        Report::create(['user_id' => $user_id ,
        'post_id' => $id, 'content' =>$content]);

        return response()->json([
            'success'=>true,
            'data'=>''
        ]);
    }

    public function updateToken(Request $request)
    {
        $id = $request->input('id');
        $device_token = $request->input('token');
        $user = User::find($id);
        $user->device_token = $device_token;
        $user->save();
        return response()->json([
            'success'=>true,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $id = $request->id;
        $all = $request->all();
        $user = User::find($id);
        if ($request->get('photo') != "" && !str_contains($request->get('photo'), "http")) {
            $image=$this->uploadImage($request->get('photo'), "logo", "user");
            $all['photo'] = url("/uploads/logo/".$image);
        }
        $all['password'] = bcrypt($all['password']);
        $user->update($all);
        History::where('user_id', $user->id)->delete();
        foreach ($all['histories'] as $history) {
            $history['user_id'] = $user->id;
            History::create($history);
        }
        return response()->json([
            'success'=>true,
            'data'=>$all
        ]);
    }

    public function getTypeNamesFromIds($ids)
    {
        $data = array();
        foreach ($ids as $id) {
            $type = Type::find($id);
            array_push($data, $type->name);
        }
        return $data;
    }

    public function getStyleNamesFromIds($ids)
    {
        $data = array();
        foreach ($ids as $id) {
            $type = Style::find($id);
            array_push($data, $type->name);
        }
        return $ids;
    }

    public function getRecipes(Request $request)
    {
        $recipes = Recipe::where('active', true)->orderBy('count', 'desc')->orderBy('id', 'desc')->get();
        foreach ($recipes as $recipe) {
            $recipe->reviews;
            $recipe->user;
        }
        return response()->json([
            'success'=>true,
            'data'=>$recipes
        ]);
    }

    public function uploadRecipe(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $content = $request->input('content');

        $image=$this->uploadImage($request->get('photo'), "recipe", "recipe");
        $image = url("/uploads/recipe/".$image);
        $recipe = Recipe::create(['user_id' => $id , 'photo' => $image,'title' =>$title, 'content' =>$content]);

        // $notification = array(
        //     'title' => "New Recipe Received",
        //     'body' => "You received new recipe"
        // );
        // $notificationData = array(
        //     "type" => 'new-recipe',
        // );
        // $this->sendNotificationToUsers($notification, $notificationData);
        return response()->json([
            'success'=>true,
        ]);
    }

    public function viewRecipe(Request $request)
    {
        $form = $request->all();
        $count = 1;
        if (Review::where(['recipe_id' => $form['recipe_id'], 'user_id' => $form['user_id']])->get()->count() == 0) {
            $recipe = Recipe::find($form['recipe_id']);
            if (!is_null($recipe->count)) {
                $count =  $recipe->count + 1;
            }
            $recipe->count = $count;
            $recipe->save();
        }
        $review = Review::updateOrCreate(['recipe_id' => $form['recipe_id'], 'user_id' => $form['user_id']], $form);
        return response()->json([
            'success'=>true,
        ]);
    }

    public function getContacts(Request $request)
    {
        $id = $request->id;
        $rooms = Room::where('active', true)
                ->where(function ($query) use ($id) {
                    $query->where('user_id', $id)
                        ->orWhere('connect_id', $id);
                })
                ->orderBy('id', 'desc')->get();

        foreach ($rooms as $room) {
            if ($room->user_id == $id) {
                $user = User::find($room->connect_id);
                $badge = Chat::where('room_id', $room->id)->where('read1', false)->get()->count();
            } else {
                $user = User::find($room->user_id);
                $badge = Chat::where('room_id', $room->id)->where('read2', false)->get()->count();
            }
            $room->user = $user;
            $room->badge = $badge;
        }
        return response()->json([
            'success'=>true,
            'data'=>$rooms
        ]);
    }

    public function getPros(Request $request)
    {
        $users = User::where('role', 1)->where('active', true)->orderBy('id')->get();
        foreach ($users as $user) {
            $user->histories;
            $user['typeOfProfessionalNames'] = $this->getTypeNamesFromIds($user->typeOfProfessional);
            $user['styleOfCookingNames'] = $this->getStyleNamesFromIds($user->styleOfCooking);
        }
        return response()->json([
            'success'=>true,
            'data'=>$users,
        ]);
    }

    public function makeChatRoom(Request $request)
    {
        $user_id = $request->user_id;
        $connect_id = $request->connect_id;
        $all = $request->all();
        $room = Room::updateOrCreate(['user_id' => $user_id, 'connect_id' => $connect_id], $all);
        $room->user = User::find($connect_id);
        Chat::where('room_id', $room->id)->update(['read1'=> true]);

        if ($room->user_id == $user_id) {
            $user = User::find($room->connect_id);
        } else {
            $user = User::find($room->user_id);
        }
        $room->user = $user;
        $room->badge = 0;

        return response()->json([
            'success'=>true,
            'data'=>$room
        ]);
    }

    public function setBlock(Request $request)
    {
        $room_id = $request->room_id;
        $user_id = $request->user_id;
        $room = Room::find($room_id);
        if ($room->user_id == $user_id) {
            $room->block1 = true;
        } else {
            $room->block2 = true;
        }
        $room->active = false;
        $room->save();
        return response()->json([
            'success'=>true,
        ]);
    }

    public function getBlocks(Request $request)
    {
        $user_id = $request->user_id;
        $rooms = Room::where('active', false)
                ->where(function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->orWhere('connect_id', $user_id);
                })
                ->orderBy('id', 'desc')->get();

        foreach ($rooms as $room) {
            if ($room->user_id == $user_id) {
                $user = User::find($room->connect_id);
                $badge = Chat::where('room_id', $room->id)->where('read1', false)->get()->count();
            } else {
                $user = User::find($room->user_id);
                $badge = Chat::where('room_id', $room->id)->where('read2', false)->get()->count();
            }
            $room->user = $user;
            $room->badge = $badge;
        }
        return response()->json([
            'success'=>true,
            'data'=>$rooms
        ]);
    }

    public function removeBlock(Request $request)
    {
        $user_id = $request->user_id;
        $room_id = $request->room_id;
        $room = Room::find($room_id);
        if ($room->user_id == $user_id) {
            $room->block1 = false;
        } else {
            $room->block2 = false;
        }
        $room->active = true;
        $room->save();
        return response()->json([
            'success'=>true,
        ]);
    }

    public function getMessage(Request $request)
    {
        $room_id = $request->input('room_id');
        $page = $request->input('page');

        $chats = Chat::where('room_id', $room_id)
        ->orderBy('id', 'desc')
        ->get();

        $data = array();
        foreach ($chats as $chat) {
            $content = $chat->content;
            $content->chat_id = $chat->id;
            array_push($data, $content);
        }

        return response()->json([
            'success'=>true,
            'data' => $data
        ]);
    }

    public function sendMessage(Request $request)
    {
        $user_id = $request->input('user_id');
        $receive_id = $request->input('receive_id');
        $room_id = $request->input('room_id');
        $message = $request->input('message');

        if($message['image64']){
            $photo = $message['image'];
            $image= $this->uploadImage($photo, "chat", "chat");
            $image = url("/uploads/chat/".$image);
            $message['image'] = $image;
        }

        $room = Room::find($room_id);
        if ($room->active == false) {
            return response()->json([
                'success'=>false,
            ]);
        }

        $send_user = User::find($user_id);
        $receive_user = User::find($receive_id);
        if ($user_id == $room->user_id) {
            $read1 = true;
            $read2 = false;
        } else {
            $read2 = true;
            $read1 = false;
        }
        $chat = Chat::create(['room_id'=>$room_id, 'read1'=>$read1, 'read2'=>$read2, 'content'=>$message]);

        $notification = array(
            'title' => $send_user->fname,
            'body' => $message['text']
        );

        $notificationData = array(
            "type" => 'new-message',
            "chat" => $chat->id,
            "room" => $room->id,
        );
        $this->sendNotificationToUser($receive_id, $notification, $notificationData);

        return response()->json([
            'success'=>true,
        ]);
    }

    public function deleteMessage(Request $request){
        $id = $request->id;
        Chat::find($id)->delete();
        return response()->json([
            'success'=>true,
        ]);
    }

    public function getOneMessage(Request $request){
        $id = $request->id;
        $chat = Chat::find($id);
        if($chat->read1 == true && $chat->read2 == true){
            return;
        }
        $chat->read1 = true;
        $chat->read2 = true;
        $chat->save();
        return response()->json([
            'success'=>true,
            'data'=>$chat->content,
        ]);
    }

    public function readAllMessage(Request $request){
        $user_id = $request->user_id;
        $room_id = $request->room_id;

        $room = Room::find($room_id);
        if ($user_id == $room->user_id) {
            $field = 'read1';
        } else {
            $field = 'read2';

        }
        Chat::where('room_id', $room_id)->update([$field => true]);
        return response()->json([
            'success'=>true,
        ]);
    }

    public function uploadChatImage(Request $request){
        $image=$this->uploadImage($request->get('photo'), "chat", "chat");
        $image = url("/uploads/chat/".$image);
        return response()->json([
            'success'=>true,
            'data'=>$image,
        ]);
    }

    public function removePhoto(Request $request){
        $photo = $request->photo;
        $this->deleteFile($photo);

        return response()->json([
            'success'=>true,
        ]);
    }

    public function deleteFile($url){
        $names = explode("uploads", $url);
        $filename = "uploads".$names[1];
        File::delete($filename);
    }

    public function sendNotificationToUser($user_id, $notification, $notificationData)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $user = User::find($user_id);
        $device_token = $user->device_token;
        if (!is_null($device_token)) {
            $fields = array(
                'to' => $device_token,
                'notification' => $notification,
                'data' => $notificationData
            );

            $headers = array(
                'Authorization: key=AAAABAbSFZE:APA91bFbaD0aAG-aoYadiJ41qzwenSFU2RnXF3wcFZ63Lx2rPxywCpp8KGlWVG8nL-pEAbxCaFcHxO_jjciWIlT0-9Y8Q5yKuJvy1YItJPR7b1jl1vy_FugPF_3Zpw5lX-Tn9QtqWpgH',
                'Content-type: Application/json'
            );
            $this->sendCurlRequest($url, 'post', json_encode($fields), $headers);
        }
    }

    public function sendNotificationToUsers($notification, $notificationData)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $users = User::whereIn('role', [0, 1])->where('active', true)->get();
        foreach ($users as $user) {
            $device_token = $user->device_token;
            if (!is_null($device_token)) {
                $fields = array(
                    'to' => $device_token,
                    'notification' => $notification,
                    'data' => $notificationData
                );

                $headers = array(
                    'Authorization: key=AAAABAbSFZE:APA91bFbaD0aAG-aoYadiJ41qzwenSFU2RnXF3wcFZ63Lx2rPxywCpp8KGlWVG8nL-pEAbxCaFcHxO_jjciWIlT0-9Y8Q5yKuJvy1YItJPR7b1jl1vy_FugPF_3Zpw5lX-Tn9QtqWpgH',
                    'Content-type: Application/json'
                );
                $this->sendCurlRequest($url, 'post', json_encode($fields), $headers);
            }
        }
    }
}
