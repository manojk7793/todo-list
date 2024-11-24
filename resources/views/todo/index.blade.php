<!DOCTYPE html>
<html>
<head>
    <title>To-Do App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/8.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.min.js"></script>
    <script>
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") }}',
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true
        });
    </script>
</head>
<body>
    <div>
        <form id="todo-form">
            <input type="text" id="todo-input" name="content" placeholder="Enter To-Do" required>
            <button type="submit">Add To-Do</button>
        </form>
    </div>

    <div id="todo-list">
        @foreach($todos as $todo)
            <div>{{ $todo->content }}</div>
        @endforeach
    </div>


    <script>
        // Handle form submission
        document.getElementById('todo-form').addEventListener('submit', function(e) {

            let input = document.getElementById('todo-input').value;

            fetch('/todo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ content: input })
            });

            document.getElementById('todo-input').value = '';
        });

        // Listen for broadcast events
        window.Echo.channel('todo-channel')
            .listen('TodoCreated', (e) => {
                console.log("New To-Do received:", e.content);

                let todoList = document.getElementById('todo-list');
                let newItem = document.createElement('div');
                newItem.textContent = e.content;
                todoList.appendChild(newItem);
            });
    </script>
</body>
</html>