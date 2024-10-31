# Eval_Mate

Eval_Mate is a Laravel-based Peer-Review Platform that enables students to register, log in, submit assignments, and add peer reviews. Teachers who are seeded in the database have exclusive access to teacher functionalities. This platform fosters collaborative feedback among students while ensuring secure access for both students and pre-defined teacher accounts.

## Features

1. **User Registration and Authentication**:
   - Users can securely register, log in, and log out.
   - Role-based access control differentiates student and teacher roles, where only teachers seeded in the database can access teacher functionalities.

2. **Assignment Submission and Management**:
   - Students can upload assignments directly on the platform, where they are stored and accessible for peer review.
   - Teachers have access to view all assignments, making grading and feedback efficient.

3. **Peer Review System**:
   - Students can submit peer reviews on their classmates' assignments to provide constructive feedback and improve learning.
   - Peer reviews are stored securely in the database, allowing teachers to oversee and assess the feedback process.

4. **Teacher-Specific Access**:
   - Only pre-seeded teachers can access teacher-specific functionalities, such as assignment management and peer review oversight.
   - Teachers can also provide additional feedback on submissions to enhance student learning.

5. **Database Management**:
   - Leveraging Laravel’s Eloquent ORM, the platform ensures efficient database operations and data handling.
   - Database seeding includes pre-set teacher accounts for secure access and role management.

## Installation

1. **Clone the Repository**:
  1) ```bash
      git clone git@github.com:Swigstan1810/Eval_Mate.git
      cd eval_mate
  
  **Install Dependencies: Ensure Composer and PHP are installed, then run:**;
  2) ```bash
      composer update

  **Serve the Application: Start the server:**;
  3) ```bash
      php artisan serve


## Usage
    1)Student Registration and Login: Students can register and log in to   upload assignments and submit peer reviews.

    2)Teacher Login: Only pre-seeded teachers can access teacher functionalities such as managing and viewing assignments and peer reviews.

    3)Assignment Submission: Students can upload assignments which can be reviewed by their peers.

    4)Peer Review Submission: Students can add reviews to peers’ assignments, allowing feedback and collaborative learning.

## Technologies Used
    1)Backend: Laravel (PHP Framework)
    2)Frontend: Blade templating engine
    3)Database: Sqlite3 (or compatible database)
    4)Authentication: Laravel’s built-in authentication with customised S-Number Login System.

## Contributing
   Contributions are welcome! Please fork the repository and create a pull request for any new features or bug fixes.


