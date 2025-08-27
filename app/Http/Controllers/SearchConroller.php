<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchConroller extends Controller
{
//    function search(Request $request)
//    {
//        $searchTerm = $request->input('search');
//        $user  = User::all();
//        if($user->has('search')){
//            $users = User::where('first_name', 'LIKE',  '%' . $user . '%')
//                ->orWhere('first_name', 'LIKE', '%' . $user . '%')
//                ->orWhere('email', 'LIKE', '%' . $user . '%')
//                ->orWhere('hobbies', 'LIKE', '%' . $user . '%')
//                ->orWhere('gender', 'LIKE', '%' . $user . '%')->get();
//            foreach ($users as $user){
//                echo"<tr>
//                       <td>{{$user->id}}</td>
//                       <td>{{$user->first_name}}</td>
//                       <td>{{$user->last_name}}</td>
//                       <td>{{$user->email}}</td>
//                        <td>{{ implode(',', json_decode($user->hobbies)) }}</td>
//                        <td>{{$user->gender}}</td>
//                        <td>
//                            <img class='img-fluid img-thumbnail' src=''{{ asset('storage/' . $user->image) }}' alt='Uploaded Image' width='200'>
//                        </td>
//                        <td style='' class='editDelete'>
//                                            <form action='{{route('users.destroy',$user->id)}}' method='POST'>
//                                                @csrf
//                                                @method('DELETE')
//                                                <button type='submit' class='btn btn-danger btn-sm my-3'>DELETE</button>
//                                            </form>
//                                            <a href='{{route('users.edit', $user->id)}}' class='btn btn-warning editbtn d-flex justify-content-center align-items-center'>Edit</a>
//                                        </td>
//                </tr>";
//            }
//
//        }
//    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $users = User::where('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('hobbies', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
                ->get();

            return response()->json([
                'html' => view('searchdata', compact('users'))->render()
            ]);
        }

        return response()->json(['html' => '']);
    }

}
