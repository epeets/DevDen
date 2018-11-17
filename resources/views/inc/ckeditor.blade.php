@auth
    @if(Route::currentRouteName() == 'posts.edit' || Route::currentRouteName() == 'posts.create')
        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
        </script>
    @endif
@endauth