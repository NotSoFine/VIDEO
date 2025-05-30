<!DOCTYPE html>
<html>
<head>
    <title>HTML Forms Example</title>
</head>
<body>
    <h2>Registration Form</h2>
    <form action="process_form.php" method="POST">
        <!-- Text inputs -->
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <!-- Password input -->
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <!-- Radio buttons -->
        <div>
            <label>Gender:</label>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
        </div>

        <!-- Checkbox -->
        <div>
            <input type="checkbox" id="newsletter" name="newsletter" value="yes">
            <label for="newsletter">Subscribe to newsletter</label>
        </div>

        <!-- Select dropdown -->
        <div>
            <label for="country">Country:</label>
            <select id="country" name="country">
                <option value="">Select a country</option>
                <option value="us">United States</option>
                <option value="uk">United Kingdom</option>
                <option value="ca">Canada</option>
            </select>
        </div>

        <!-- Textarea -->
        <div>
            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" rows="4" cols="50"></textarea>
        </div>

        <!-- File upload -->
        <div>
            <label for="photo">Profile Photo:</label>
            <input type="file" id="photo" name="photo">
        </div>

        <!-- Submit button -->
        <div>
            <input type="submit" value="Register">
            <input type="reset" value="Clear Form">
        </div>
    </form>
</body>
</html>