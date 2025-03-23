<!DOCTYPE html>
<html>
<head>
    <title>Team Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color:#15a967;
        }
         /* Footer Styles */
footer {
  background-color: #d8ffe0 ; /* Dark background color */
  color: var(--primary); /* Light text color */
  padding: 20px;
  text-align: center;
  font-size: 14px;
  line-height: 1.5; 
}

footer a {
  color: var(--primary); /* Link color */
  text-decoration: none; /* Remove underline from links */
}

footer a:hover {
  text-decoration: underline; /* Add underline on hover */
}

/* Style for the container */
.footer-container {
  max-width: 960px; /* Match the width of your main content */
  margin: 0 auto; /* Center the footer content */
  display: flex;
  flex-direction: column;
  align-items: center; /* Center content horizontally within the container */
}
.navbar a{
    text-decoration: none;
    color: #d8ffe0;
    padding-right: 2%;
}

/* Social Icons (Example) */
.social-icons {
  margin-top: 10px;
}

.social-icons a {
  display: inline-block;
  margin: 0 5px;
  font-size: 20px; /* Adjust size as needed */
  color: var(--primary); /* Icon color */
}

.social-icons a:hover {
  color: #007bff; /* Change color on hover */
}

/* Copyright Notice */
.copyright {
  margin-top: 10px;
  font-size: 12px;
}
    </style>
</head>
<body>

<div class="navbar">
    <div >TechieSport</div>
    <a href="ndex1.html"><i class="fas fa-dashboard"></i> Dashboard</a>
</div>

<div class="sidebar">
    <ul>
        <li><a href="ndex1.html"><i class="fas fa-dashboard"></i> Home</a></li>
        <li><a href="football.html"><i class="fas fa-users"></i> Explore Teams</a></li>
        <li><a href="admin.html"><i class="fas fa-users-cog"></i>  Admin</a></li>

    </ul>
</div>
<div class="content">
    <div class="card">
    <button onclick="history.back()" style="font-size: 18px; padding: 10px 20px;"><i class="fas fa-arrow-left"></i> Back</button>
        <h1 style="text-align: center;color: #030148;">Team Details</h1>

        <?php
        require 'db_connect.php';

        // Get the team ID from the query parameter
        $teamId = isset($_GET['team_id']) && is_numeric($_GET['team_id']) ? (int)$_GET['team_id'] : 0;

        if ($teamId > 0) {
            try {
                // Fetch team information
                $stmt = $pdo->prepare("SELECT team_name, sport, league, coach FROM teams WHERE id = ?");
                $stmt->execute([$teamId]);
                $team = $stmt->fetch();

                if ($team) {
                    echo "<h1>" . htmlspecialchars($team['team_name']) . "</h1>";
                    echo "<p>Sport: " . htmlspecialchars($team['sport']) . "</p>";
                    echo "<p>League: " . htmlspecialchars($team['league']) . "</p>";
                    echo "<p>Coach: " . htmlspecialchars($team['coach']) . "</p>";

                    // Fetch players for the team
                    $stmt = $pdo->prepare("SELECT player_name, admission_number, year_of_study, position FROM players WHERE team_id = ?");
                    $stmt->execute([$teamId]);
                    $players = $stmt->fetchAll();

                    echo "<h3>Players</h3>";
                    if ($players) {
                        echo "<table>";
                        echo "<thead><tr><th>Player Name</th><th>Admission Number</th><th>Year of Study</th><th>Position</th></tr></thead>";
                        echo "<tbody>";
                        foreach ($players as $player) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($player['player_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($player['admission_number']) . "</td>";
                            echo "<td> Year  "  . htmlspecialchars($player['year_of_study']) . "</td>";
                            echo "<td>" . htmlspecialchars($player['position']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p>No players found for this team.</p>";
                    }
                } else {
                    echo "<p>Team not found.</p>";
                }
            } catch (PDOException $e) {
                echo "Error fetching team details: " . $e->getMessage();
            }
        } else {
            echo "<p>Invalid team ID.</p>";
        }
        ?>
    </div>
    </div>
    <footer>
        <div class="footer-container">
          <p>
            &copy; 2025 TechieSport. All rights reserved. |
            <a href="/privacy">Privacy Policy</a> |
            <a href="/terms">Terms of Service</a>
          </p>
    
          <div class="social-icons">
            <a href="#" title="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
          </div>
    
          <p class="copyright">
              Website designed and developed by Dezmils.
          </p>
        </div>
      </footer>

</body>
</html>
