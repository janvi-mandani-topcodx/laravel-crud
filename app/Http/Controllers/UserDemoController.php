<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserDemoRequest;
use App\Http\Requests\UpdateUserDemoRequest;
use App\Models\UsersDemo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\UserDemoRepository;
class UserDemoController extends Controller
{
    private $userDemoRepo;

    public function __construct(UserDemoRepository $userDemoRepository)
    {
        $this->UserDemoRepo = $userDemoRepository;
    }
    public function index(Request $request)
    {
        $userDemo = UsersDemo::all();
        if ($request->ajax()) {
            return DataTables::of(UsersDemo::get())
                ->editColumn('image', function ($userDemo) {
                    $userImage = $userDemo->Image_url;
                    $images = '';
                    if (is_array($userImage)) {
                        foreach ($userImage as $img) {
                            $images .= '<img src="' . $img . '" alt="user image" width="80" height="80" class="img-thumbnail"/><br>';
                        }
                    }
                    return $images;
                })
                ->editColumn('hobbies' , function ($userDemo) {
                    return json_decode($userDemo->hobbies);
                })
                ->rawColumns(['image'])
                ->make(true);
        }
        return view('user_demo.index', compact('userDemo'));
    }

    public function create()
    {
        return view ('user_demo.create');
    }

    public function store(CreateUserDemoRequest $request)
    {
        $input = $request->all();
        $this->UserDemoRepo->store($input);
    }

    public function show(string $id)
    {
        $userData = UsersDemo::find($id);
        return view('user_demo.show', compact('userData' ));
    }

    public function edit(string $id)
    {
        $userData = UsersDemo::find($id);
        return view('user_demo.edit', compact('userData'));
    }

    public function update(UpdateUserDemoRequest $request, string $id)
    {
        $userDemo = UsersDemo::find($id);
        $input = $request->all();
        $deleteImg = $userDemo->getMedia('users-demo');
        if($request->hasFile('image')){
            foreach ($input['image'] as $file) {
                $userDemo->addMedia($file)->toMediaCollection('users-demo');
            }
            if($deleteImg){
                foreach ($deleteImg as $images){
                    $images->delete();
                }
            }
        }
        $this->UserDemoRepo->update($input, $userDemo);
    }

    public function destroy(string $id)
    {
        $user = UsersDemo::find($id);
        $user->delete();
        $deleteImg = $user->getMedia('users-demo');
        if($deleteImg)
        {
            foreach ($deleteImg as $img) {
                $img->delete();
            }
        }
        return response()->json(['success' => 'User demo delete successfully.']);
    }
}
