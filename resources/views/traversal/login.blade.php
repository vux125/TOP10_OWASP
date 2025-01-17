
        <div class="container">
        <h2>Login</h2>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary click">Login</button>
    
        <h5 class="username"></h5>
        <h5 class="password"></h5>
    </div>
    
    <script>
        document.querySelector('.click').addEventListener('click', function() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            document.querySelector('.username').innerHTML = `Username: ${email}`;
            document.querySelector('.password').innerHTML = `Password: ${password}`;
        });
    </script>
