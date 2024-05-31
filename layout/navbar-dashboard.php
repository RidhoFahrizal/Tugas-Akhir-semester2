<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Navbar</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            width: 100%;
            background-color: #007bff;
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            padding: 10px 20px;
            box-sizing: border-box;
        }
        .navbar h4 {
            margin: 0;
            font-size: 1.2em;
            border-bottom: none;
            flex: 1;
        }
        .navbar a {
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            display: block;
            font-size: 1em;
            transition: background-color 0.3s, padding-bottom 0.3s;
        }
        .navbar a:hover {
            background-color: #0056b3;
            padding-bottom: 20px;
        }
        .content {
            padding: 20px;
            flex: 1;
        }
    </style>
</head>
<body>
<div class="navbar">
    <h4>Menu</h4>
    <a href="dashboard.php">Beranda</a>
    <a href="user-profil.php">Profil</a>
    <a href="documents.php">Document</a>
    <a href="calendar.php">Calendar</a>
    <a href="to-do-list.php">To-do-List</a>
</div>
<div class="content">
    <!-- Main content goes here -->
</div>
</body>
</html>
