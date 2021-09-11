<h1>detail</h1>
@if (isset($item['file_path']))
<img src="{{asset('storage/' . $item['file_path'])}}" alt="{{asset('storage/' . $item['file_path'])}}">
@endif

<p>投稿ID: {{$item['id']}}</p>
<p>投稿内容: {{$item['content']}}</p>
<p>投稿時間: {{$item['created_at']}}</p>
<a href="{{route('edit', ['content_id' => $item['id']])}}">編集</a>
<form action="{{route('delete',['content_id' => $item['id']])}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$item['id']}}">
    <input type="submit" value="削除">
</form>