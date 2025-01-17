<div class="container">
    <h2>Register</h2>
    <form id="registerForm" method="POST">
        
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <h5 class="register-success mt-3" style="display: none;">Register Success</h5>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Simulate form submission success
        document.querySelector('.register-success').style.display = 'block';
    });
</script>