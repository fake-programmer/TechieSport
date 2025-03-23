"use strict";

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

document.addEventListener('DOMContentLoaded', function () {
  // Function to extract team ID from the URL
  function getTeamIdFromUrl() {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('teamId');
  }

  var teamId = getTeamIdFromUrl();

  if (!teamId) {
    document.getElementById('team-name').textContent = 'Error: No team ID provided.';
    return;
  }

  function fetchTeamData(teamId) {
    var response, teamData;
    return regeneratorRuntime.async(function fetchTeamData$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            _context.prev = 0;
            _context.next = 3;
            return regeneratorRuntime.awrap(fetch("/api/teams/".concat(teamId)));

          case 3:
            response = _context.sent;

            if (response.ok) {
              _context.next = 6;
              break;
            }

            throw new Error("HTTP error! status: ".concat(response.status));

          case 6:
            _context.next = 8;
            return regeneratorRuntime.awrap(response.json());

          case 8:
            teamData = _context.sent;
            return _context.abrupt("return", teamData);

          case 12:
            _context.prev = 12;
            _context.t0 = _context["catch"](0);
            console.error('Error fetching team data:', _context.t0);
            document.getElementById('team-name').textContent = 'Error: Could not load team data.';
            return _context.abrupt("return", null);

          case 17:
          case "end":
            return _context.stop();
        }
      }
    }, null, null, [[0, 12]]);
  }

  function populateTeamStats(teamData) {
    var statsTableBody, _i, _Object$entries, _Object$entries$_i, statistic, value, row, statisticCell, valueCell, rosterList, achievementList;

    return regeneratorRuntime.async(function populateTeamStats$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            if (teamData) {
              _context2.next = 2;
              break;
            }

            return _context2.abrupt("return");

          case 2:
            document.getElementById('team-name').textContent = teamData.teamName;
            document.getElementById('team-league').textContent = "League: ".concat(teamData.league);
            document.getElementById('team-coach').textContent = "Coach: ".concat(teamData.coach); // Optional: Set team logo if you have a URL

            if (teamData.logoUrl) {
              document.getElementById('team-logo').src = teamData.logoUrl;
              document.getElementById('team-logo').alt = "".concat(teamData.teamName, " Logo");
            } // Populate statistics table


            statsTableBody = document.getElementById('stats-table').querySelector('tbody');
            statsTableBody.innerHTML = ''; // Clear existing rows

            for (_i = 0, _Object$entries = Object.entries(teamData.statistics); _i < _Object$entries.length; _i++) {
              _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2), statistic = _Object$entries$_i[0], value = _Object$entries$_i[1];
              row = document.createElement('tr');
              statisticCell = document.createElement('td');
              statisticCell.textContent = statistic;
              valueCell = document.createElement('td');
              valueCell.textContent = value;
              row.appendChild(statisticCell);
              row.appendChild(valueCell);
              statsTableBody.appendChild(row);
            } // Populate roster list


            rosterList = document.getElementById('roster-list');
            rosterList.innerHTML = ''; // Clear existing list items

            teamData.roster.forEach(function (player) {
              var listItem = document.createElement('li');
              listItem.textContent = player;
              rosterList.appendChild(listItem);
            }); // Populate achievements list

            achievementList = document.getElementById('achievement-list');
            achievementList.innerHTML = ''; // Clear existing list items

            teamData.achievements.forEach(function (achievement) {
              var listItem = document.createElement('li');
              listItem.textContent = achievement;
              achievementList.appendChild(listItem);
            });

          case 15:
          case "end":
            return _context2.stop();
        }
      }
    });
  } // Main execution flow


  (function _callee() {
    var teamData;
    return regeneratorRuntime.async(function _callee$(_context3) {
      while (1) {
        switch (_context3.prev = _context3.next) {
          case 0:
            _context3.next = 2;
            return regeneratorRuntime.awrap(fetchTeamData(teamId));

          case 2:
            teamData = _context3.sent;
            _context3.next = 5;
            return regeneratorRuntime.awrap(populateTeamStats(teamData));

          case 5:
          case "end":
            return _context3.stop();
        }
      }
    });
  })();
});
//# sourceMappingURL=script.dev.js.map
