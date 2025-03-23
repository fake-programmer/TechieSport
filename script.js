document.addEventListener('DOMContentLoaded', () => {

    // Function to extract team ID from the URL
    function getTeamIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('teamId');
    }

    const teamId = getTeamIdFromUrl();

    if (!teamId) {
        document.getElementById('team-name').textContent = 'Error: No team ID provided.';
        return;
    }

    async function fetchTeamData(teamId) {
        try {
            const response = await fetch(`/api/teams/${teamId}`);  // Replace with your actual API endpoint
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const teamData = await response.json();
            return teamData;
        } catch (error) {
            console.error('Error fetching team data:', error);
            document.getElementById('team-name').textContent = 'Error: Could not load team data.';
            return null;
        }
    }

    async function populateTeamStats(teamData) {
        if (!teamData) return;

        document.getElementById('team-name').textContent = teamData.teamName;
        document.getElementById('team-league').textContent = `League: ${teamData.league}`;
        document.getElementById('team-coach').textContent = `Coach: ${teamData.coach}`;

        // Optional: Set team logo if you have a URL
        if (teamData.logoUrl) {
            document.getElementById('team-logo').src = teamData.logoUrl;
            document.getElementById('team-logo').alt = `${teamData.teamName} Logo`;
        }

        // Populate statistics table
        const statsTableBody = document.getElementById('stats-table').querySelector('tbody');
        statsTableBody.innerHTML = ''; // Clear existing rows

        for (const [statistic, value] of Object.entries(teamData.statistics)) {
            const row = document.createElement('tr');
            const statisticCell = document.createElement('td');
            statisticCell.textContent = statistic;
            const valueCell = document.createElement('td');
            valueCell.textContent = value;
            row.appendChild(statisticCell);
            row.appendChild(valueCell);
            statsTableBody.appendChild(row);
        }

        // Populate roster list
        const rosterList = document.getElementById('roster-list');
        rosterList.innerHTML = ''; // Clear existing list items
        teamData.roster.forEach(player => {
            const listItem = document.createElement('li');
            listItem.textContent = player;
            rosterList.appendChild(listItem);
        });

         // Populate achievements list
        const achievementList = document.getElementById('achievement-list');
        achievementList.innerHTML = ''; // Clear existing list items
        teamData.achievements.forEach(achievement => {
            const listItem = document.createElement('li');
            listItem.textContent = achievement;
            achievementList.appendChild(listItem);
        });
    }

    // Main execution flow
    (async () => {
        const teamData = await fetchTeamData(teamId);
        await populateTeamStats(teamData);
    })();

});



