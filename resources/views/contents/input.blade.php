<h1>input</h1>

<form action="{{route('save')}}" method="post" enctype="multipart/form-data">
    @csrf
    <textarea name="content" cols="30" rows="10"></textarea>
    <input type="submit" value="送信">
    <br>
    @error('file')
        {{$message}}
        <br>
    @enderror
    <input type="file" name="file">
</form>