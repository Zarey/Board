<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\User;
use App\Models\Category;

class BoardController extends Controller
{
    public function Index(Request $request)
    {
        $categories = DB::table('categories')
            ->where('on_off', '=', 1)
            ->get();

        //$advertisements = Advertisement::all();
        $advertisements = Advertisement::select('board_advertisements.*', 'users.name AS author_name')
        ->where([['status', '=', 2], ['on_off', '=', 1]])
        ->orderBy('up_adv', 'desc')
        ->leftJoin('users', 'users.id', '=', 'board_advertisements.author_id')
        ->paginate(10);

        $title = "Доска объявлений Сочи";
        return view('frontend.board.index', compact('title', 'categories', 'advertisements'));
    }

    public function Cat(Request $request, $id)
    {
        $category = Category::find($id);
        
        //$advertisements = Advertisement::all();
        $advertisements = Advertisement::select('board_advertisements.*', 'users.name AS author_name')
        ->where([['category_id', '=', $id], ['status', '=', 2], ['on_off', '=', 1]])
        ->orderBy('up_adv', 'desc')
        ->leftJoin('users', 'users.id', '=', 'board_advertisements.author_id')
        ->paginate(10);

        if ($category && $advertisements) {
            $title = $category->name." - Доска объявлений Сочи";
            return view('frontend.board.cat', compact('title', 'category', 'advertisements'));
        }
        return abort(404);
    }

    public function Adv(Request $request, $url)
    {
        $advertisement = Advertisement::select('board_advertisements.*', 'users.name AS author_name')
        ->where([['status', '=', 2], ['on_off', '=', 1], ['url', '=', $url]])
        ->leftJoin('users', 'users.id', '=', 'board_advertisements.author_id')
        // ->find($id);
        ->first();

        if ($advertisement) {

            $title = $advertisement->header.' - '.$advertisement->city;
            return view('frontend.board.adv', compact('title', 'advertisement'));
        }
        return abort(404);
    }

    public function User($id) {
        $user = User::find($id);

        if ($user) {
            $advertisements = Advertisement::where([['status', '=', 2], ['on_off', '=', 1], ['author_id', '=', $user->id]])
            ->orderBy('up_adv', 'desc')
            ->paginate(10);

            $title = $user->name;
            return view('frontend.board.user', compact('title', 'user', 'advertisements'));
        }
        return abort(404);
    }

}