<?php

namespace App\Repositories;
use App\Models\UsersDemo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserDemoRepository extends BaseRepository
{
    public function model()
    {
        return UsersDemo::class;
    }
    public function store($data)
    {
        $media = Arr::only($data, 'image');

        $userData = Arr::only($data, ['first_name' , 'last_name', 'email' , 'password' , 'hobbie'  , 'status']);
        $userData['password'] = Hash::make($userData['password']);
        $userData['hobbies'] = json_encode($userData['hobbie']);
        if(isset($userData['status'])){
            $userData['status'] = 1 ;
        }
        else{
            $userData['status'] = 0 ;
        }
        $user = UsersDemo::create($userData);
        if($media) {
            foreach ($media['image'] as $file) {
                $user->addMedia($file)->toMediaCollection('users-demo');
            }
        }
        return response()->json(['success'=>'User created successfully.']);
    }


    public function update($data , $userDemo){
        $userData = Arr::only($data, ['first_name' , 'last_name', 'email' , 'password' , 'hobbie'  , 'status']);
        $userData['password'] = Hash::make($userData['password']);
        $userData['hobbies'] = json_encode($userData['hobbie']);
        if(isset($userData['status'])){
            $userData['status'] = 1 ;
        }
        else{
            $userData['status'] = 0 ;
        }

        $userDemo->update($userData);
        return response()->json(['success'=>'User updated successfully.']);
    }

}
