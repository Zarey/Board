<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\User;

use app\Helpers\Helpers;


class ModerateController extends Controller
{
    // Добавить общее правило для контроллера, что если id не 1, возвращаем return redirect()->route('/');

    // Ждут одобрения
    public function index()
    {
        $advertisements = Advertisement::select('board_advertisements.*', 'users.name AS author_name')
        ->where('status', 0)->orWhere('status', 1)
        ->leftJoin('users', 'users.id', '=', 'board_advertisements.author_id')
        ->orderBy('up_adv', 'desc')
        ->paginate(10);

        $count = DB::table('board_advertisements')->where('status', 0)->orWhere('status', 1)->count();

        $title = "Ждут одобрения";
        return view('backend.moderate.index', compact('title', 'advertisements', 'count'));
    }
    // Одобренные
    public function approved()
    {
        $advertisements = Advertisement::select('board_advertisements.*', 'users.name AS author_name')
        ->where('status', 2)
        ->leftJoin('users', 'users.id', '=', 'board_advertisements.author_id')
        ->orderBy('up_adv', 'desc')
        ->paginate(10);

        $count = DB::table('board_advertisements')->where('status', 2)->count();

        $title = "Одобренные";
        return view('backend.moderate.index', compact('title', 'advertisements', 'count'));
    }
    // Отклоненные
    public function rejected()
    {
        $advertisements = Advertisement::select('board_advertisements.*', 'users.name AS author_name')
        ->where('status', 3)
        ->leftJoin('users', 'users.id', '=', 'board_advertisements.author_id')
        ->orderBy('up_adv', 'desc')
        ->paginate(10);

        $count = DB::table('board_advertisements')->where('status', 3)->count();

        $title = "Отклоненные";
        return view('backend.moderate.index', compact('title', 'advertisements', 'count'));
    }

    /* *********************************** moderate *********************************** */

    // Форма модерации сообщения
    public function moderate($id)
    {
        $advertisement = Advertisement::find($id);

        if ($advertisement) {

            $draft_category = Category::find($advertisement->draft_category_id);
            $category = Category::find($advertisement->category_id);

            $title = "Форма модерации сообщения";
            return view('backend.moderate.moderate', compact('title', 'advertisement', 'draft_category', 'category', 'id'));
        }

        $title = "Сообщение было удалено";
        return view('backend.moderate.absent', compact('title'));
    }

    // Одобрение изменений и внесение в ячейки для показа
    public function approve(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $advertisement = Advertisement::find($id);
            $advertisement->header = $advertisement->draft_header;
            $advertisement->advcontent = $advertisement->draft_advcontent;
            $advertisement->category_id = $advertisement->draft_category_id;
            $advertisement->city = $advertisement->draft_city;
            $advertisement->phone = $advertisement->draft_phone;
            if ($advertisement->url == '')
                $advertisement->url = Helpers::url_translit($advertisement->draft_header).'_'.time();
            // Если image не соответствует draft_image, оно фактически ниже оно будет удалено из базы
            // А значит, удаляем и сам файл
            if ($advertisement->image !== $advertisement->draft_image) {
                $this->delete_image($advertisement->image);
            }
            $advertisement->image = $advertisement->draft_image;
            $advertisement->status = 2;
            $advertisement->save();
        }

        //\Session::flash('message', 'Изменения одобрены!');
        return redirect()->route('moderate', $id);
    }

    // Отклонение (добавить возможность комментировать и комментарий по умолчанию)
    public function reject(Request $request, $id)
    {
        if ($request->isMethod('post')) {
	    	$advertisement = Advertisement::find($id);
	    	$advertisement->status = 3;
	    	$advertisement->save();
    	}

        //\Session::flash('message', 'Изменения отклонены!');
        return redirect()->route('moderate', $id);
    }

    /* *********************************** editable *********************************** */

    public function editable($id)
    {
        $categories = DB::table('categories')
            ->where('on_off', '=', 1)
            ->get();

        $advertisement = Advertisement::find($id);
        if ($advertisement) {
            $title = "Редактировать сообщение";
            return view('backend.moderate.editable', compact('title', 'advertisement', 'categories', 'id'));
        }

        $title = "Сообщение было удалено";
        return view('backend.moderate.absent', compact('title'));
    }

    // Внесение правок и автоодобрение при совпадении черновика и оригинала
    public function change(Request $request, $id)
    {
        $this->validate($request, [
            'draft_header' => 'required|max:60',
            'draft_advcontent' => 'required|max:500',
            'draft_category_id' => 'required|max:3',
            'draft_city' => 'max:50',
            'draft_phone' => 'required|max:25',
            'price' => 'max:8',
        ]);

        $advertisement = Advertisement::find($id);

        if ($request->isMethod('post')) {
            $advertisement->draft_header = $request->input('draft_header');
            $advertisement->draft_advcontent = $request->input('draft_advcontent');
            $advertisement->draft_category_id = $request->input('draft_category_id');
            $advertisement->draft_city = $request->input('draft_city');
            $advertisement->draft_phone = $request->input('draft_phone');
            if ($request->hasFile('image')) {
                $advertisement->draft_image = $draft_image_filename;
            }
            $advertisement->price = $request->input('price');
            $advertisement->header = $request->input('header');
            $advertisement->advcontent = $request->input('advcontent');
            $advertisement->category_id = $request->input('category_id');
            $advertisement->city = $request->input('city');
            $advertisement->phone = $request->input('phone');
            if ($advertisement->url == '')
                $advertisement->url = Helpers::url_translit($advertisement->draft_header).'_'.time();
            if ($request->hasFile('image')) {
                $advertisement->image = $image_filename;
            }
            // Если черновик не был изменен, он не требует одобрения
            if (
                $advertisement->status == 2 &&
                $advertisement->draft_header === $advertisement->header &&
                $advertisement->draft_advcontent === $advertisement->advcontent &&
                $advertisement->draft_category_id == $advertisement->category_id &&
                $advertisement->draft_city === $advertisement->city &&
                $advertisement->draft_phone === $advertisement->phone &&
                $advertisement->draft_image === $advertisement->image
            ) {
                $advertisement->status = 2;
            // Если объявление еще ни разу не одобрялось, пусть статус остается 0 при любых правках
            // Это касается и алертов, чтобы не говорить про предыдущую одобренную версию, которой еще нет
            } elseif ($advertisement->status == 0) {
                $advertisement->status = 0;
            } else {
                $advertisement->status = 1;
            }
            $advertisement->updated_at = now();
            $advertisement->save();
        }
        \Session::flash('message', 'Изменения внесены!'); // перенести
        return redirect()->route('moderate.editable', $id);
    }

    // Поднятие объявления
    public function upadv(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $advertisement = Advertisement::find($id);
            $advertisement->up_adv = now();
            $advertisement->save();
        }
        \Session::flash('message', 'Объявление поднято!');
        return redirect()->route('moderate.editable', $id);
    }

    // Включить объявление
    public function onadv(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $advertisement = Advertisement::find($id);
            $advertisement->on_off = 1;
            $advertisement->save();
        }
        \Session::flash('message', 'Объявление включено!');
        return redirect()->route('moderate.editable', $id);
    }

    // Выключить объявление
    public function offadv(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $advertisement = Advertisement::find($id);
            $advertisement->on_off = 0;
            $advertisement->save();
        }
        \Session::flash('message', 'Объявление отключено!');
        return redirect()->route('moderate.editable', $id);
    }

    // Сюда направляем для удаления
    public function destroy(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $advertisement = Advertisement::find($id);
            if ($advertisement->delete()) \Session::flash('message', 'Объявление ID '.$id.' успешно удалено!');
        }
        return redirect()->route('moderate.editable', $id);
    }

    // Функция удаления изображения (перенести в хелперы...)
    public function delete_image($imgname) {
            if (is_file(storage_path('app/images/' .$imgname)))
                unlink(storage_path('app/images/' .$imgname));

            // И превью
            if (is_file(storage_path('app/images/preview/' .$imgname)))
                unlink(storage_path('app/images/preview/' .$imgname));
    }
}
