<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <title>Hangman</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div id="remaining" class="mx-auto pb-5">
                    <span id="remainingChars">{{ $remainingGuesses }}</span> guesses left
                </div>
                <div style="display: none;" id="newGame" class="mx-auto pb-5">
                    <span id="result">You won :-) </span> <a class="btn btn-info ml-2" href="/reset">Play a new game</a>
                </div>
                <div id="word" class="title m-b-md">
                    {{ $word }}
                </div>
                <div class="mx-auto pb-5">
                    <h2>Hint : {{ $description }}</h2>
                </div>

                <div>
                    <ul id="guessChars" class="list-inline">
                        @foreach ($remaingChars as $char)
                        <li class="list-inline-item">
                            <button class="btn btn-outline-primary guess">
                                {{ $char }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".guess").click(function (e) {

            var char = $.trim($(this).html());
            $(this).parent().hide();

            $.ajax({
                type: 'POST',
                url: "{{ route('ajaxRequest.post') }}",
                data: {char: char},
                success: function (data) {
                    $('#word').text(data.word);
                    $('#remainingChars').text(data.remainingGuesses);
                    switch (data.gameStatus) {
                        case '{{ Game::GAME_STATUS_LOST }}':
                            $('#remaining').hide();
                            $('#guessChars').hide();
                            $('#result').html('You lost ;-(');
                            $('#newGame').show();
                            break;
                        case '{{ Game::GAME_STATUS_WON }}':
                            $('#remaining').hide();
                            $('#newGame').show();
                            $('#guessChars').hide();
                            break;
                        default:
                        // code block
                    }
                }
            });
        });
    </script>
</html>
