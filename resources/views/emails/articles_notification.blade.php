<!DOCTYPE html>
<html>
<head>
    <title>New Article Notification</title>
</head>
<body>
    <h1>New Articles: {{$articlesCount}}</h1>

    <p>
        @foreach ($articles as $article)
            <p>
                <h2>{{ $article->getTitle() }}</h2>
                <p>{{ $article->getAbstract() }}</p>
                <p>{{ $article->getText() }}</p>
            </p>
        @endforeach
    </p>
    
</body>
</html>
