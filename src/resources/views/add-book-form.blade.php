<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Add Book
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('store-book') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" name="author" id="author" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Book</button>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <table class="table table-bordered">
          <thead>
          <tr>
            <th data-column="title">Title</th>
            <th data-column="author">Author</th>
            <th>Delete</th>
          </tr>
          </thead>
        <tbody id="table-content"></tbody>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>
                        <form method="POST" action="{{ route('books.delete', $book->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('script.js') }}"></script>
</body>
</html>