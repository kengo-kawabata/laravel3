<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
    @yield('styles')
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <nav class="my-navbar">
            <a class="my-navbar-brand" href="/">ToDo App</a>
            <div class="my-navbar-control">
                @if(Auth::check())
                    <span class="my-navbar-item">ようこそ, {{ Auth::user()->name }}さん</span>
                    ｜
                    <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
                    ｜
                    <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
                @endif
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <!--
    *   ログアウトのクリックイベント
    *   機能：ログアウトリンクのクリック時に真下のログアウトフォームを送信する
    *   用途：ログアウトを実施する
    -->
    @if(Auth::check())
        <script>
            document.getElementById('logout').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
            });

            // アコーディオンメニューの＋とーの表示
            function toggleAccordion(accordion) {
            const icon = accordion.querySelector('.icon');

            if (accordion.open) {
                icon.textContent = '＋';
            } else {
                icon.textContent = 'ー';
            }
        }


        // 検索機能
        function searchTasks() {
            // 検索ボックスに入力された値を取得し、大文字に変換
            const keyword = document.getElementById('searchInput').value.toUpperCase();
            const rows = document.getElementsByClassName("taskRow");

            for (let i = 0; i < rows.length; i++) {
                // taskのタイトルを取得
                const cells = rows[i].getElementsByTagName("td")[0];
                // celltextに取得した文字列を代入
                const cellText = cells.textContent || cells.innerText;
                const found = cellText.toUpperCase().indexOf(keyword) > -1;
                rows[i].style.display = found ? "" : "none";
            }
        }
        
        </script>
    @endif
    @yield('scripts')
</body>
</html>
