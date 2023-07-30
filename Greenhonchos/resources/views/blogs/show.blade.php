<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title ?? 'My Blog' }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS Styles */
        .blog-post {
            border: 1px solid #ddd;
            padding: 200px;
            background-color: #f9f9f9;
        }

        .blog-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .blog-tag {
            font-size: 16px;
            color: #666;
        }

        .blog-content {
            font-size: 18px;
            color: #444;
        }

        /* Optional: Center the blog on the page */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="blog-post">
                    <h2 class="blog-title">{{ $blog->title }}</h2>
                    <img src="{{ asset($blog->image) }}" alt="Blog Image" class="img-fluid mt-3">
                    <p class="blog-tag">Tag: {{ $blog->tags }}</p>
                    <p class="blog-content">{{ $blog->content }}</p>
                    <a href="{{url('blogs')}}" class="edit btn btn-primary btn-sm ">Back</a>
                </div>
            </div>

        </div>


    </div>

</body>

</html>