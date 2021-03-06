<?php

namespace App\Http\Controllers;
use App\Models\Content;
use App\Models\ContentImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ContentController extends Controller
{
  public function input()
  {
    return view('contents.input');
  }
  public function output()
  {
    $items = Content::all();
    foreach ($items as &$item) {
      $file_path = ContentImage::select('file_path')->where('content_id', $item['id'])->first();
      if (isset($file_path)) {
          $item['file_path'] = $file_path['file_path'];
      }
    }
    return view('contents.output', [
        'items' => $items,
    ]);
  }
  public function save(Request $request)
  {
    $input_content = new Content();
    $input_content->content = $request['content'];
    $input_content->save();
    if ($request->file('file')) {
      $this->validate($request, [
          'file' => [
              // 空でないこと
              'required',
              // 画像ファイルであること
              'image',
              // MIMEタイプを指定
              'mimes:jpeg,png',
          ]
      ]);

      if ($request->file('file')->isValid([])) {
          $file_name = $request->file('file')->getClientOriginalName();
          $file_path = Storage::putFile('/images', $request->file('file'), 'public');

          $image_info = new ContentImage();
          $image_info->content_id = $input_content->id;
          $image_info->file_name = $file_name;
          $image_info->file_path = $file_path;
          $image_info->save();
      }
    }
    return redirect(route('output'));
  }
  public function detail($content_id)
  {
    $item = Content::find($content_id);
    $file_path = ContentImage::select('file_path')
        ->where('content_id', $item['id'])
        ->first();
        if (isset($file_path)) {
            $item['file_path'] = $file_path['file_path'];
        }
    return view('contents.detail', [
        'item' => $item,
    ]);
  }
  public function edit($content_id)
  {
    $item = Content::find($content_id);

    return view('contents.edit', [
        'item' => $item,
    ]);
  }

  public function update(Request $request)
  {
    $content_info = Content::find($request['id']);
    $content_info->content = $request['content'];
    $content_info->save();
    return redirect(route('output'));
  }
  public function delete(Request $request)
  {
    $contents_delete_query = Content::select('*');
    $contents_delete_query->find($request['id']);
    $contents_delete_query->delete();
    $content_images_delete_query = ContentImage::select('*');
    if ($content_images_delete_query->find($request['id'] !== '[]')) {
        $content_images_delete_query->delete();
    }

    return redirect(route('output'));
  }
}
