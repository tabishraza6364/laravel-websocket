<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body class="antialiased">
    <div class="container p-5">
        <div class="mb-3">
            <textarea class="form-control" rows="3" id="message" placeholder="Message..."></textarea>
        </div>
        <button class="btn btn-primary" type="button" onclick="sendMessage()">Send</button>
        <div id="notification" class="mt-5"></div>
    </div>

    <script src="//{{ Request::getHost() }}:{{ config('app.laravel_echo_port') }}/socket.io/socket.io.js"></script>
    @vite(['resources/js/app.js'])
    <script type="text/javascript">
        const _timer = setInterval(() => {
            if (window.Echo) {
                clearInterval(_timer);
                window.Echo.channel('user-channel')
                    .listen('.UserEvent', (data) => {
                        console.log(data);
                        $("#notification").append(`<div class="alert alert-success">${data.message}</div>`);
                    });
            }
        }, 100);

        function sendMessage() {
            const message = document.getElementById('message')?.value || '';
            axios.post('/api/send-message', {message}).then(() => {
                document.getElementById('message').value = '';
            }).catch(err => {
                console.log(err);
            });
        }
    </script>
</body>

</html>
