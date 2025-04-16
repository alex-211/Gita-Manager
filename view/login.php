<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="index.php?url=login" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Accedi">
    </form>

    <!-- Button to log in as user ID 1 -->
    <form action="index.php?url=loginAsUser" method="post">
        <input type="hidden" name="user_id" value="1">
        <button type="submit">Log in as User ID 1</button>
    </form>

    <!-- Button to log in as user ID 4 -->
    <form action="index.php?url=loginAsUser" method="post">
        <input type="hidden" name="user_id" value="4">
        <button type="submit">Log in as User ID 4 (PRF)</button>
    </form>
</body>
</html>