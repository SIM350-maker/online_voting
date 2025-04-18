# 🗳️ Online Voting System

This project is a simple web-based Online Voting System developed using html embedded in PHP and MySQL Database. It includes voter and candidate registration, login, voting, and results viewing. The system ensures a user-friendly experience while handling different election roles and vote counts securely.

---

## 🧾 MySQL Database Structure

This system uses a MySQL database to store and manage data such as registered voters, candidates, votes, and login credentials.

> ![Screenshot](screenshots/database_tables.png)  
*Screenshot showing the structure of the database tables.*

---

## 📂 Project Files & Screenshots Overview

### `candidate_login.php`
Allows candidates to log in using their **Name and ID** for verification.
> ![Screenshot](screenshots/candidate_login.png)

---

### `voter_login.php`
Allows voters to log in using their **email and password**.
> ![Screenshot](screenshots/voter_login.png)

---

### `login.php`
Login interface where users specify their **role** (either **Candidate** or **Voter**) before being directed to their respective login process.
> ![Screenshot](screenshots/login.png)

---

### `kregester.php`
Registration interface that lets users choose their **registration type** – either **Voter** or **Candidate**.
> ![Screenshot](screenshots/kregester.png)

---

### `register_voter.php`
Form for registering a new voter by collecting **Name, Email, Phone Number**, and **Password**.
> ![Screenshot](screenshots/register_voter.png)

---

### `register_candidate.php`
Form to register a new candidate, including **Candidate Name**, **Position** (e.g., Senator, President), and **Election Type**.
> ![Screenshot](screenshots/register_candidate.png)

---

### `vote.php`
Displays available candidates and their respective positions. Voters use a **dropdown menu** to select and cast their vote for a specific candidate.
> ![Screenshot](screenshots/vote.png)

---

### `view_candidates.php`
Displays a list of all candidates along with their positions, such as **President**, **Senator Assistant**, etc.
> ![Screenshot](screenshots/view_candidates.png)

---

### `view_results.php`
Displays total **votes counted per candidate** along with the **position** they contested for, providing a summary of the election results.
> ![Screenshot](screenshots/view_results.png)

---
