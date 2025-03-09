<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Complaint & Review</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #004080;
            padding: 15px 50px;
            color: white;
        }
        .navbar img {
            height: 50px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 500px;
            background: url('carosel/1.jpg') no-repeat center center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .hero-content {
            position: relative;
            z-index: 2;
            font-size: 24px;
        }
        .hero-buttons {
            margin-top: 20px;
        }
        .hero-buttons a {
            background: #007BFF;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            margin: 5px;
        }
        .hero-buttons a:hover {
            background: #0056b3;
        }

        /* Latest Complaints Section */
        .complaint-list {
            padding: 50px;
            text-align: center;
        }
        .complaint-list h3 {
            font-size: 28px;
            color: #004080;
        }
        .complaint-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 15px;
            margin: 10px auto;
            border-radius: 5px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }
        .complaint-card i {
            font-size: 24px;
            color: #007BFF;
        }
        .complaint-details {
            flex-grow: 1;
            margin-left: 15px;
            text-align: left;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
        .status-pending {
            background-color: orange;
        }
        .status-resolved {
            background-color: green;
        }
        .status-rejected {
            background-color: red;
        }

        /* Game Section */
        .game-container {
            text-align: center;
            margin-top: 50px;
        }
        #game-box {
    display: none;
    position: relative;
    width: 400px;
    height: 400px;
    border: 2px solid #000;
    background: white;
    margin: auto;
    overflow: hidden;
}

.dot {
    width: 40px;  /* Adjusted for better visibility */
    height: 40px;
    position: absolute;
    cursor: pointer;
    background: url('https://upload.wikimedia.org/wikipedia/commons/e/ec/Soccer_ball.svg') no-repeat center/cover;
    border-radius: 50%;
}


        .game-buttons {
            margin-top: 20px;
        }
        .game-buttons button {
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }
        .start-btn {
            background: #28a745;
            color: white;
        }
        .exit-btn {
            background: #dc3545;
            color: white;
        }
        .start-btn:hover {
            background: #218838;
        }
        .exit-btn:hover {
            background: #c82333;
        }

        /* Footer Styling */
.footer {
    background: linear-gradient(to right, #1e1e2f, #3a3a5d);
    color: white;
    padding: 50px 0;
    text-align: center;
    font-family: 'Arial', sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: auto;
    align-items: flex-start;
}

.footer-logo img {
    width: 120px;
}

.footer h3 {
    color: #f5c542;
    margin-bottom: 15px;
    font-size: 22px;
}

.footer p, .footer ul {
    font-size: 16px;
    color: #ccc;
}

.footer ul {
    list-style: none;
    padding: 0;
}

.footer ul li {
    margin: 8px 0;
}

.footer ul li a {
    color: #f0f0f0;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer ul li a:hover {
    color: #f5c542;
}

.footer-contact p a {
    color: #f0f0f0;
    text-decoration: none;
}

.footer-contact p a:hover {
    color: #f5c542;
}

.footer-bottom {
    background: rgba(0, 0, 0, 0.2);
    padding: 15px 0;
    margin-top: 30px;
    font-size: 14px;
}

    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <img src="carosel/pictures_1_logo.png" height="150px" alt="Logo">
        <div>
            <a href="index.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1>Welcome to Smart Complaint & Review CUCEK</h1>
            <p>Submit your complaints easily and track their status.</p>
            <div class="hero-buttons">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
    </div>

    <!-- Latest Complaints -->
    <div class="complaint-list">
        <h3>Latest Complaints</h3>
        <?php 
        include 'db.php'; 
        session_start();
        $query = 'SELECT category, description, status FROM complaints ORDER BY id DESC LIMIT 5';
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $statusClass = "";
            if ($row['status'] == 'Pending') $statusClass = "status-pending";
            if ($row['status'] == 'Resolved') $statusClass = "status-resolved";
            if ($row['status'] == 'Rejected') $statusClass = "status-rejected";
            echo '<div class="complaint-card">
                    <i class="fas fa-exclamation-circle"></i>
                    <div class="complaint-details">
                        <b>' . htmlspecialchars($row['category']) . ':</b> ' . htmlspecialchars($row['description']) . '
                    </div>
                    <span class="status-badge ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span>
                </div>';
        }
        ?>
    </div>

    <!-- Game Section -->
    <div class="game-container">
        <h2>Bored? Try this game!</h2>
        <div class="game-buttons">
            <button class="start-btn" onclick="startGame()">Start Game</button>
            <button class="exit-btn" onclick="exitGame()">Exit Game</button>
        </div>
        <div id="game-box"></div>
        <div id="score">Score: 0</div>
    </div>


    <!-- Footer Section -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="carosel/pictures_1_logo.png" alt="CUCEK Logo">
        </div>
        
        <div class="footer-about">
            <h3>About CUCEK</h3>
            <p>
                Cochin University College of Engineering Kuttanad (CUCEK) is a leading institution offering top-tier engineering and research programs. Established in 1999, it has grown into a center of excellence in technical education.
            </p>
        </div>

        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">🏛 B-Tech</a></li>
                <li><a href="#">🎓 MCA</a></li>
                <li><a href="#">🔬 Research</a></li>
                <li><a href="#">📚 Library</a></li>
                <li><a href="#">⚽ Sports</a></li>
                <li><a href="#">❤️ NSS</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h3>Contact Us</h3>
            <p>📍 Pulincunnu, Alappuzha, Kerala</p>
            <p>📧 Email: <a href="mailto:info@cucek.ac.in">info@cucek.ac.in</a></p>
            <p>📞 Phone: +91-XXXXXXXXXX</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2025 CUCEK | All Rights Reserved | Designed by <strong>Mohit Raj and Shahwaz Alam</strong></p>
    </div>
</footer>


    <script>
   let score = 0;
let gameActive = false;
let dot;

function startGame() {
    if (!gameActive) {
        gameActive = true;
        document.getElementById("game-box").style.display = "block";
        document.getElementById("score").innerText = "Score: 0";
        score = 0;
        createMovingDot();
    }
}

function exitGame() {
    gameActive = false;
    document.getElementById("game-box").style.display = "none";
    if (dot) {
        dot.remove();
    }
}

function createMovingDot() {
    if (!dot) {
        dot = document.createElement("div");
        dot.className = "dot";
        document.getElementById("game-box").appendChild(dot);
        
        dot.addEventListener("click", function () {
            if (gameActive) {
                score++;
                document.getElementById("score").innerText = "Score: " + score;
                moveDot();
            }
        });
    }
    moveDot();
}

function moveDot() {
    let gameBox = document.getElementById("game-box");
    let maxX = gameBox.clientWidth - 40;  // Football size
    let maxY = gameBox.clientHeight - 40;

    let randomX = Math.floor(Math.random() * maxX);
    let randomY = Math.floor(Math.random() * maxY);

    dot.style.left = randomX + "px";
    dot.style.top = randomY + "px";
}

    </script>

</body>
</html>
