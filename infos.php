<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="infos.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stundenplan</title>
</head>
<body>
  <nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Homepage</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Timy</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="infos.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="stundenplan.html">Timetable</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user.html">User</a>
              </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <main>
        <div class="card_add">
          <div class="card" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Teacher</h5>
              <p class="card-text">Some quick information on your teacher</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">subject 1</li>
              <li class="list-group-item">subject 2</li>
            </ul>
            <div class="card-body">
              <a href="teacher_add.php" class="card-link">Card link</a>
            </div>
          </div>
          <button type="button" class="btnbtn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="margin-top: 180px; margin-left: 50px; width: 80px; height: 80px; background: none; border: none;"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
          </svg></button>
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">New Teacher</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="teacher_add.php">
                      <div class="input-group mb-3">
                        <span class="input-group-text">first name</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="first name" name="first_name">
                        <span class="input-group-text">last name</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="last name" name="last_name">
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text">subject 1</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="subject1" name="subject_1">
                        <span class="input-group-text">subject 2</span>
                        <input type="text" class="form-control" placeholder="..." aria-label="subject2" name="subject_2">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </form>
                </div>
                
              </div>
            </div>
          </div>
          
  </main>
    
</body>
</html>