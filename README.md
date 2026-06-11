# Digital Basketball League Management System


The system digitises the management of basketball leagues, replacing manual/paper-based processes with an efficient, role-based web application.


---

## Project Overview

The Digital Basketball League Management System (DBLMS) provides a centralised platform for organising and managing basketball league activities. It supports three distinct user roles — Administrator, Coach, and Player — each with a tailored interface and access level.

## Features

### Administrator
- **Dashboard** — Live summary of leagues, teams, players, upcoming fixtures, and results needing entry
- **League Management** — Create, edit, and manage multiple leagues with seasons and status tracking
- **Team Management** — Create teams, assign coaches, set home courts, manage rosters
- **Player Registration** — Register players with full profile (position, jersey number, height, weight, age), optionally create login accounts
- **Fixture Scheduling** — Schedule matches between teams with date, time, venue, and week number
- **Result Recording** — Enter quarter-by-quarter scores (Q1–Q4) for each team; totals computed automatically; record individual player statistics per match
- **User Management** — Create and manage user accounts with role assignment (Admin/Coach/Player)
- **League Standings** — Auto-computed from match results: wins, losses, points for/against, point differential, win percentage

### Coach
- **Dashboard** — Overview of coached teams, upcoming fixtures, and recent results
- **Roster View** — Full player roster with positions, jersey numbers, and season averages

### Player
- **Dashboard** — Personal profile, season average statistics (PPG/APG/RPG/SPG/BPG), recent game log
- **Fixtures** — View all league fixtures and results
- **Standings** — View live league standings table

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.2 / Laravel 11 |
| Database | MySQL 8 (via XAMPP) |
| Frontend | Bootstrap 5.3.3 + Bootstrap Icons 1.11.3 (CDN) |
| Server | Apache (XAMPP) |
| Auth | Laravel built-in session authentication |
| Architecture | MVC (Model-View-Controller) |

---

## System Requirements

- XAMPP (Apache + MySQL + PHP 8.2+)
- Composer
- Web browser (Chrome, Firefox, Edge)

---

## Installation (XAMPP)

### 1. Clone / Copy the Project
Place the project folder inside your XAMPP `htdocs` directory:
```
C:\xampp\htdocs\project\digital_basketball_league_management_system\
```

### 2. Create the Database
Open **phpMyAdmin** at `http://localhost/phpmyadmin` and create a new database:
```sql
CREATE DATABASE basketball_league;
```

### 3. Configure Environment
Copy `.env.example` to `.env` and update the following values:
```env
APP_NAME="Basketball League"
APP_URL=http://localhost/project/digital_basketball_league_management_system

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=basketball_league
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install PHP Dependencies
Open a terminal in the project root and run:
```bash
php artisan key:generate
```
> If using XAMPP's PHP directly: `c:\xampp\php\php.exe artisan key:generate`

### 5. Run Migrations and Seed Sample Data
```bash
php artisan migrate:fresh --seed
```
This creates all database tables and populates the system with sample leagues, teams, players, fixtures, results, and player statistics.

### 6. Access the Application
Open your browser and navigate to:
```
http://localhost/project/digital_basketball_league_management_system/
```

---

## Demo Login Credentials

| Role | Email | Password |
|---|---|---|
| Administrator | admin@basketball.com | admin123 |
| Coach (1) | coach1@basketball.com | coach123 |
| Coach (2) | coach2@basketball.com | coach123 |
| Player | player1@basketball.com | player123 |

---

## Database Schema

| Table | Description |
|---|---|
| `users` | User accounts with role (admin/coach/player) |
| `leagues` | League records with season, status, dates |
| `teams` | Teams linked to leagues and coaches |
| `players` | Player profiles linked to teams and optional user accounts |
| `league_matches` | Match fixtures with teams, venue, date, week, status |
| `match_results` | Quarter scores (Q1–Q4) per match; totals stored as computed columns |
| `player_stats` | Individual player statistics per match (points, assists, rebounds, steals, blocks, fouls, minutes) |

---

## Sample Data (Seeded)

| Entity | Count |
|---|---|
| Leagues | 2 |
| Teams | 8 |
| Players | 40 |
| Users | 12 |
| Fixtures | 14 |
| Completed Matches (with results) | 6 |
| Player Stat Records | 60 |

**League 1 — Edo Basketball League (Active)**
Teams: Iyamho Ballers, Auchi Warriors, Ekpoma Giants, Uromi Storm

**League 2 — National Universities Basketball League (Active)**
Teams: Lagos Underdogs, Benin City Kings, Abuja Senators, Port Harcourt Panthers

---

## User Roles & Access Control

Access is controlled by a `RoleMiddleware` that checks the authenticated user's role against the required role for each route group.

| Route Prefix | Middleware | Role Required |
|---|---|---|
| `/admin/*` | `auth`, `role:admin` | Administrator |
| `/coach/*` | `auth`, `role:coach` | Coach |
| `/player/*` | `auth`, `role:player` | Player |
| `/login`, `/register` | `guest` | Unauthenticated only |

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/         # Dashboard, League, Team, Player, Match, User controllers
│   │   ├── Coach/         # Coach dashboard and team view
│   │   ├── Player/        # Player dashboard, fixtures, standings
│   │   └── AuthController.php
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php
│   ├── League.php
│   ├── Team.php
│   ├── Player.php
│   ├── LeagueMatch.php
│   ├── MatchResult.php
│   └── PlayerStat.php
database/
├── migrations/            # 7 migration files for all tables
└── seeders/               # League, Team, Player, Match seeders
resources/views/
├── layouts/app.blade.php  # Main Bootstrap 5 layout with sidebar
├── auth/                  # Login and registration views
├── admin/                 # Admin CRUD views for all entities
├── coach/                 # Coach dashboard and roster views
└── player/                # Player dashboard, fixtures, standings
```

---

## Screenshots

### Landing & Authentication
![Landing Page](screenshots/01_landing_page.png)
![Login Page](screenshots/02_login_page.png)

### Admin — Dashboard & Leagues
![Admin Dashboard](screenshots/03_admin_dashboard.png)
![Leagues List](screenshots/04_leagues_list.png)
![Create League Form](screenshots/05_league_create_form.png)
![League Standings](screenshots/06_league_standings.png)

### Admin — Teams & Players
![Teams List](screenshots/07_teams_list.png)
![Create Team Form](screenshots/08_team_create_form.png)
![Players List](screenshots/09_players_list.png)
![Player Profile](screenshots/10_player_profile.png)

### Admin — Fixtures & Results
![Fixtures List](screenshots/11_fixtures_list.png)
![Schedule Match Form](screenshots/12_schedule_match_form.png)
![Record Result Form](screenshots/13_record_result_form.png)
![Match Result Scoreboard](screenshots/14_match_result_scoreboard.png)

### Admin — Users
![Users List](screenshots/15_users_list.png)

### Coach Interface
![Coach Dashboard](screenshots/16_coach_dashboard.png)
![Coach Team Roster](screenshots/17_coach_team_roster.png)

### Player Interface
![Player Dashboard](screenshots/18_player_dashboard.png)
![Player Fixtures](screenshots/19_player_fixtures.png)
![Player Standings](screenshots/20_player_standings.png)

---

## Screenshot Guide for Documentation

Take the following screenshots for your project report chapters:

| # | Page | URL | Chapter Use |
|---|---|---|---|
| 1 | Landing / Home page | `/` | System overview |
| 2 | Login page | `/login` | Authentication module |
| 3 | Admin Dashboard | `/admin` | Admin interface |
| 4 | Leagues list | `/admin/leagues` | League management |
| 5 | Create League form | `/admin/leagues/create` | Data entry |
| 6 | League Standings (show) | `/admin/leagues/{id}` | Standings computation |
| 7 | Teams list | `/admin/teams` | Team management |
| 8 | Players list | `/admin/players` | Player management |
| 9 | Player profile | `/admin/players/{id}` | Stats display |
| 10 | Fixtures list | `/admin/matches` | Schedule management |
| 11 | Record Result form | `/admin/matches/{id}/result` | Result recording module |
| 12 | Match Result view | `/admin/matches/{id}` | Scoreboard + player stats |
| 13 | Coach Dashboard | `/coach` | Coach interface |
| 14 | Coach Team Roster | `/coach/team/{id}` | Roster management |
| 15 | Player Dashboard | `/player` | Player interface |
| 16 | Player Standings | `/player/standings` | Player standings view |

---

## License

This project is licensed under the [MIT License](LICENSE) — free to use, modify, and distribute with attribution.
