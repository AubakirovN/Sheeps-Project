<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        

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
                padding-top:15px;
                padding-bottom:15px;

            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .farm-title {
                padding-top: 35px;
            }

            .zagon {
                height: 200px;
                overflow: scroll;
                border: 1px solid #ccc;
            }

            .commands {
                padding-top: 25px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            {{--<form action="#">--}}
                            <fieldset>
                                <legend class="farm-title">Ферма</legend>
                                <span>День:</span>
                                <p id="day">0</p>

                                <?$index = 1?>
                                @foreach ($paddock as $key => $list)
                                    <div class="col-md-6">
                                        <h3>Загон №{{ $key  }}</h3>

                                        <div id="paddock{{ $key  }}" class="zagon">
                                            {{--@for($i = 1; $i <= $value; $i++, $index++ )--}}
                                            @foreach ($list as $sheepId)
                                                <div id="sheep{{ $sheepId }}" class="name">Sheep {{ $sheepId }}</div>
                                                {{--@endfor--}}
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset>

                            <div class="col-md-12 commands">
                                <form>
                                    <div class="form-group">
                                        <button id="reset" class="btn btn-danger">Reset</button>
                                        {{--<button id="sleep" class="btn btn-warning">Sleep</button>--}}
                                    </div>
                                    <div class="form-group">
                                        {{--<input type="text" placeholder="Enter command">--}}
                                        <select name="command" id="">
                                            <option value="add">Add</option>
                                            <option value="sleep">Sleep</option>
                                        </select>
                                        <input type="submit" name="send" value="Send">
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 info-block">
                                <p><a href="/stat/">Общая статистика</a></p>
                                <p class="bg-danger">Reset = Очищает таблицу овец и историю</p>
                                <p class="bg-success">Add = Добавляет одну овцу</p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
    $(function () {

        function add() {
            $.ajax({
                url: '/reproduce/',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#paddock' + data.paddock).append(
                        '<div id="sheep' + data.sheep_id + '" class="name">Sheep ' + data.sheep_id + '</div>'
                    );
                }
            });
        }

        function sleep() {
            $.ajax({
                url: '/sleep/',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#sheep' + data.sleep.id).hide();

                    $('#sheep' + data.moved.id).appendTo('#paddock' + data.moved.to);
                }
            });
        }

        function kill() {
            $.ajax({
                url: '/kill/',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    $('#sheep' + data.killed_ship_id).hide();
                   
                }
            });
        }

       

        $('input[type=submit]').on('click', function () {
            var cmd = $('select').val();

            if (cmd == 'add') {
                add();
            } else if (cmd == 'sleep') {
                sleep();
            }

            return false;
        });

        $('#reset').on('click', function () {
            $.ajax({
                url: '/reset',
                success: function () {

                    window.location.reload();
                }
            });

            setDay(0);
            clearInterval(timer);
            clearInterval(new_ship);
            clearInterval(kill_ship);


           //clearInterval(kill_time);

        });

        var timer = setInterval(function () {
            var day = localStorage.getItem('day') ? localStorage.getItem('day') : 0;
            day = parseInt(day) + 1;
            setDay(day);
            /*
            if (day % 10 == 0 && day > 0) {
                add();
                
            }
            
            if (day % 20 == 0 && day > 0) {
                kill();
            } */
        }, 10000);

        var new_ship = setInterval(function () {
            add();
        },10000);

        var kill_ship = setInterval(function () {
            kill();
        },20000);


        function setDay(day) {
            localStorage.setItem('day', day);
            $('#day').html(day);
        }


    });
</script>
    </body>
</html>
