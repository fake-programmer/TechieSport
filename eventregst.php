<!DOCTYPE html>
<html>
<head>
    <title>Create Event (Simple Local)</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic CSS (as before) */
        label { display: block; margin-bottom: 5px; }
        input, select, textarea { width: 300px; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; box-sizing: border-box; }
        .error { color: red; }
        #message { margin-top: 10px; padding: 10px; border: 1px solid #ccc; display: none; } /* For displaying messages */


        /*Example stylesheet*/
body {
  font-family: sans-serif;
  margin: 20px;
}

h1 {
  color: #333;
}

form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="date"],
input[type="time"],
select,
textarea {
  width: 100%;
  padding: 8px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* Ensures padding doesn't affect width */
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="time"]:focus,
select:focus,
textarea:focus {
  border-color: #5cb85c; /* Highlight on focus */
  outline: none;
  box-shadow: 0 0 5px rgba(92, 184, 92, 0.5);
}

button[type="submit"] {
  background-color: #5cb85c;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #449d44;
}




    </style>
</head>
<body>

<h1>Create a New Event (Simple Local)</h1>

<form id="eventForm">

    <div>
        <label for="event_type">Event Type:</label>
        <select id="event_type" name="event_type">
            <option value="">-- Select --</option>
            <option value="Game">Game</option>
            <option value="Practice">Practice</option>
            <option value="Meeting">Meeting</option>
        </select>
        <p id="event_type_error" class="error"></p>
    </div>

    <div>
        <label for="sport">Sport:</label>
        <input type="text" id="sport" name="sport" required>
        <p id="sport_error" class="error"></p>
    </div>

    <div>
        <label for="team">Team :</label>
        <select id="team" name="team">
            <option value="">-- Select Team --</option>
            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'dezmils', 'dezmils', 'sports');

            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            }

            // Fetch teams from the database
            $sql = "SELECT id, team_name FROM teams";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["id"] . '">' . $row["team_name"] . '</option>';
            }
            } else {
            echo '<option value="">No teams available</option>';
            }

            // Close connection
            $conn->close();
            ?>
        </select>
        <input type="text" id="team" name="team">
    </div>

    <div>
        <label for="facility">Facility:</label>
        <input type="text" id="facility" name="facility">
    </div>

    <div>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <p id="date_error" class="error"></p>
    </div>

    <div>
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>
        <p id="time_error" class="error"></p>
    </div>

    <div>
        <label for="description">Description (Optional):</label>
        <textarea id="description" name="description" rows="4"></textarea>
    </div>

    <button type="submit">Create Event</button>

    <div id="message"></div>

</form>

<script>
  document.getElementById('eventForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Clear any previous error messages
    document.querySelectorAll('.error').forEach(el => el.textContent = '');

    // Get form data
    const formData = new FormData(this);

    // Basic client-side validation
    let isValid = true;
    if (!formData.get('event_type')) {
        document.getElementById('event_type_error').textContent = 'Event Type is required.';
        isValid = false;
    }
    if (!formData.get('sport')) {
        document.getElementById('sport_error').textContent = 'Sport is required.';
        isValid = false;
    }
     if (!formData.get('date')) {
        document.getElementById('date_error').textContent = 'Date is required.';
        isValid = false;
    }
     if (!formData.get('time')) {
        document.getElementById('time_error').textContent = 'Time is required.';
        isValid = false;
    }

    if (!isValid) {
        return;
    }

    // Send data to the server using Fetch API
    fetch('process_event.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      const messageDiv = document.getElementById('message');
      messageDiv.style.display = 'block';
      messageDiv.textContent = data.message;  // Just display the message

        if(data.status === 'success'){
          messageDiv.style.backgroundColor = '#d4edda';
          messageDiv.style.color = '#155724';
          document.getElementById('eventForm').reset();
        } else {
          messageDiv.style.backgroundColor = '#f8d7da';
          messageDiv.style.color = '#721c24';
        }
    })
    .catch(error => {
      console.error('Error:', error); // Log error to console only
      const messageDiv = document.getElementById('message');
      messageDiv.style.display = 'block';
      messageDiv.textContent = 'An error occurred. Check the console.';
    });
  });
</script>

</body>
</html>
