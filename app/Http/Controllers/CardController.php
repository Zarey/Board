<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Validator;

use App\Models\User;

class CardController extends Controller
{
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    // Форма редактирования публичных данных
    // Имя, телефон, описание, фото
    public function edit(Request $request, $id)
    {
        $user = User::find($id);

        $title = "Контакты для объявлений";
        return view('backend.card.edit', compact('title', 'user', 'id'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:users,name,'.$id.'|max:25', 
            'phone' => 'required|unique:users,phone,'.$id.'|max:25', 
            'city' => 'max:50',
        ]);

        if ($request->isMethod('put')) {
            $user = User::find($id);
            $user->name = strip_tags($request->input('name'));
            $user->phone = preg_replace('/[^0-9\+]/', '', strip_tags($request->input('phone')));
            $user->city = strip_tags($request->input('city'));
            $user->save();
        }

        \Session::flash('message', 'Контакты сохранены!');
        return redirect()->route('card.edit', $id);
    }

}
