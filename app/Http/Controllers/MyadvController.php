<?php

// добавить действие "поднять"
// Проверять права автора в if
// для админа сделать отдельный контроллер

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\User;

class MyadvController extends Controller
{
    // Выводим все объявления пользователя
    public function index()
    {
        $advertisements = Advertisement::where('author_id', Auth::id())->orderBy('updated_at', 'desc')->paginate(10);

        $title = "Мои объявления";
        return view('backend.myadv.index', compact('title', 'advertisements'));
    }

    // Выводим страницу для создания нового объявления
    // Посылаем форму в store для сохранения
    public function create()
    {
        $user = User::find(Auth::id());

        $categories = DB::table('categories')
                ->where('on_off', '=', 1)
                ->get();

        $title = "Создать новое объявление";
        return view('backend.myadv.create', compact('title', 'user', 'categories'));
    }

    // Создаём объявление
    // Переадресуем на страницу редактирования
    public function store(Request $request)
    {
        $this->validate($request, [
            'draft_header' => 'required|max:60',
            'draft_advcontent' => 'required|max:2000',
            'draft_category_id' => 'required|max:3',
            'draft_city' => 'max:50',
            'draft_phone' => 'required|max:25',
            'price' => 'max:8',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:16384',
        ]);

        if($request->hasFile('image')) {
            $image       = $request->file('image');
            $ext = $request->file('image')->getClientOriginalExtension();
            //позже с транслитерацией $image->getClientOriginalName();
            $filename    = time().'.'.$ext;

            $image_crop = Image::make($image->getRealPath());              
            $image_crop->fit(600, 450);
            $image_crop->save(storage_path('app/images/' .$filename));

            $image_preview = Image::make($image->getRealPath());              
            $image_preview->fit(200, 150);
            $image_preview->save(storage_path('app/images/preview/' .$filename));
        }

        $advertisement = new Advertisement;
        if ($request->isMethod('post') && Auth::id()) {
            $advertisement->draft_header = strip_tags($request->input('draft_header'));
            $advertisement->draft_advcontent = strip_tags($request->input('draft_advcontent'));
            $advertisement->draft_city = strip_tags($request->input('draft_city'));
            $advertisement->draft_phone = strip_tags($request->input('draft_phone'));
            $advertisement->draft_category_id = strip_tags($request->input('draft_category_id'));
            if ($request->hasFile('image')) {
                $advertisement->draft_image = $filename;
            }
            $advertisement->price = intval(str_replace(' ', '', $request->input('price')));
            $advertisement->status = 0;
            $advertisement->author_id = Auth::id();
            $advertisement->up_adv = now();
            $advertisement->save();
        }
        //\Session::flash('message', 'Объявление создано! После проверки модератором оно появится в поиске.');
        return redirect()->route('myadv.edit', $advertisement->id); // и добавить сообщение об успешном добавлении
    }

    public function show($id)
    {
        // Используем общественный view для просмотра и включенных и отключенных объявлений пользователя
        // Разумеется, право видеть свои объявления получает пользователь по своему id
    }

    // Выводим страницу для редактирования объявления по id
    // При сохранении отправляем ее в update
    public function edit($id)
    {
        $categories = DB::table('categories')
                ->where('on_off', '=', 1)
                ->get();

        $advertisement = Advertisement::find($id);
        if ($advertisement) {

            $title = $advertisement->draft_header;
            return view('backend.myadv.edit', compact('title', 'advertisement', 'categories', 'id'));
        }
        return abort(404);

    }

    // Сохраняем внесенные в объявление изменения
    // Затем снова переадресуем на страницу edit
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'draft_header' => 'required|max:60',
            'draft_advcontent' => 'required|max:2000',
            'draft_category_id' => 'required|max:3',
            'draft_city' => 'max:50',
            'draft_phone' => 'required|max:25',
            'price' => 'max:8',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:16384',
        ]);

        if($request->hasFile('image')) {
            $image       = $request->file('image');
            $ext = $request->file('image')->getClientOriginalExtension();
            //позже с транслитерацией $image->getClientOriginalName();
            $filename    = time().'.'.$ext;

            $image_crop = Image::make($image->getRealPath());              
            $image_crop->fit(600, 450);
            $image_crop->save(storage_path('app/images/' .$filename));

            $image_preview = Image::make($image->getRealPath());              
            $image_preview->fit(200, 150);
            $image_preview->save(storage_path('app/images/preview/' .$filename));
        }

        $advertisement = Advertisement::find($id);

        if ($request->isMethod('put') && $advertisement) {
            $advertisement->draft_header = strip_tags($request->input('draft_header'));
            $advertisement->draft_advcontent = strip_tags($request->input('draft_advcontent'));
            $advertisement->draft_category_id = strip_tags($request->input('draft_category_id'));
            $advertisement->draft_city = strip_tags($request->input('draft_city'));
            $advertisement->draft_phone = strip_tags($request->input('draft_phone'));
            if ($request->hasFile('image')) {
                $oldname = $advertisement->draft_image;
                $advertisement->draft_image = $filename;
                // Если имя больше не фигурирует ни в draft_image ни в image
                if ($advertisement->image !== $oldname) {
                    $this->delete_image($oldname);
                }
            }
            $advertisement->price = intval(str_replace(' ', '', $request->input('price')));
            $advertisement->updated_at = now();
            $advertisement->up_adv = now(); // Почему бы и не поднять при обновлении
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
            $advertisement->save();
        }
        //\Session::flash('message', 'Изменения сохранены!');
        return redirect()->route('myadv.edit', $id); // и добавить сообщение об успешном обновлении
    }

    // Сюда направляем для удаления
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        // Проверить на соответствие id пользователя
        if ($advertisement) {

            $this->delete_image($advertisement->draft_image);
            $this->delete_image($advertisement->image);

            $advertisement->delete();
        }

        \Session::flash('message', 'Ваше объявление успешно удалено!');
        return redirect()->route('myadv.index');
    }

    // Поднять объявление
    public function up($id)
    {
        $advertisement = Advertisement::find($id);


        if ($advertisement) {
            // Неделя = 604800
            // Если прошла неделя, можно поднять
            if (strtotime($advertisement->up_adv)+604800 < strtotime(now())) {
                $advertisement->up_adv = now();
                $advertisement->save();
            }
        }

        \Session::flash('message', 'Объявление поднято!');
        return redirect()->route('myadv.edit', $id); // и добавить сообщение об успешном поднятии
    }

    // Включить объявление
    public function on($id)
    {
        $advertisement = Advertisement::find($id);

        if ($advertisement) {
            $advertisement->on_off = 1;
            $advertisement->save();
        }

        \Session::flash('message', 'Объявление включено!');
        return redirect()->route('myadv.edit', $id); // и добавить сообщение об успешном поднятии
    }
    // Выключить объявление
    public function off($id)
    {
        $advertisement = Advertisement::find($id);

        if ($advertisement) {
            $advertisement->on_off = 0;
            $advertisement->save();
        }

        // \Session::flash('message', 'Объявление отключено!');
        return redirect()->route('myadv.edit', $id); // и добавить сообщение об успешном поднятии
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