<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：scripts を指定
*   用途：javascriptライブラリー「flatpickr」のスタイルシートを指定
-->
@section('styles')
    <!-- 「flatpickr」の デフォルトスタイルシートをインポート -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- 「flatpickr」の ブルーテーマの追加スタイルシートをインポート -->
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">

    <style>
        /* 登録した内容の表示 */
        .content{
            margin-top: 10px;
            margin-left: 10px
        }

        /* タスクにホバーした時のカーソル */
        .task_title{
            cursor: pointer;
        }

        /* 登録内容がない時のテキストの色 */
        .no_content{
            color: #808080
        }

        /* アコーディオンメニューのアイコン */
        .icon {
            margin-right: 5px;
            font-weight: bold
        }
        
        /* タスクの検索ヘッダー */
        .task_flex{
            display: flex;
            justify-content: space-between
        }

        .search_cover{
            text-align: center
        }
    </style>
@endsection

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：タスクを追加するページのHTMLを表示する
-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-4">
            <nav class="panel panel-default">
                <div class="panel-heading">フォルダ</div>
                <div class="panel-body">
                    <a href="{{ route('folders.create') }}" class="btn btn-default btn-block">
                        フォルダを追加する
                    </a>
                </div>
                <div class="list-group">
                    <table class="table foler-table">
                        @foreach($folders as $folder)
                            @if($folder->user_id === Auth::user()->id)
                                <tr>
                                    <td>
                                        <a href="{{ route('tasks.index', ['folder' => $folder->id]) }}" class="list-group-item {{ $folder_id === $folder->id ? 'active' : '' }}">
                                            {{ $folder->title }}
                                        </a>
                                    </td>
                                    <td><a href="{{ route('folders.edit', ['folder' => $folder->id]) }}">編集</a></td>
                                    <td><a href="{{ route('folders.delete', ['folder' => $folder->id]) }}">削除</a></td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                </div>
            </nav>
        </div>
        <div class="column col-md-8">
            <div class="panel panel-default">
                <div class="task_flex panel-heading">
                    <div>タスク</div>
                    <div class="search_cover">

                        <form id="searchForm" onsubmit="searchTasks(); return false;">
                            <input type="text" name="keyword" id="searchInput" placeholder="タスク名検索">
                            <button type="button" onclick="searchTasks()">検索</button>
                        </form> 

                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-right">
                        <a href="{{ route('tasks.create', ['folder' => $folder_id]) }}" class="btn btn-default btn-block">
                            タスクを追加する
                        </a>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>タイトル</th>
                            <th>状態</th>
                            <th>期限</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr class="taskRow">
                                <td>
                                    <details class="accordion" onclick="toggleAccordion(this)">
                                            <summary class="task_title"><span class="icon">＋</span>{{ $task->title }}</summary>
                                                {{-- 内容の表示 --}}
                                                @if($task->content)
                                                    <p class="content" style="white-space:pre-wrap;">{{ $task->content }}</p>
                                                @else
                                                    <p class="content no_content">※内容が登録されていません。</p>
                                                @endif
                                    </details>
                                </td>
                                <td>
                                    <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                </td>
                                <td>{{ $task->formatted_due_date }}</td>
                                <td><a href="{{ route('tasks.edit', ['folder' => $task->folder_id, 'task' => $task->id]) }}">編集</a></td>
                                <td><a href="{{ route('tasks.delete', ['folder' => $task->folder_id, 'task' => $task->id]) }}">削除</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection
