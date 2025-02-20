<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <a class="nav-link d-flex align-items-center gap-2 text-decoration-none transition-all hover-text-primary" aria-current="page" href="/">
          <i class="bi bi-people-fill"></i>
          <span>Персонажи</span>
          <?php if (empty($id)): ?>
            <span class="badge bg-secondary"><?php echo $total; ?></span>
          <?php endif; ?>
        </a>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Скачать csv
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" download href="../characters_all.csv">Персонажи</a></li>
            <li>
              <!-- <hr class="dropdown-divider"> -->
            </li>
            <!-- <li><a class="dropdown-item" href="#">Эпизоды</a></li> -->
          </ul>
        </li>
        <a class="nav-link " aria-current="page" href="https://github.com/OlegRemizoff/rickandmortyapi" target="_blank">GitHub</a>
      </ul>
      <?php if (empty($id)): ?>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button disabled class="btn btn-outline-success" type="submit">Search</button>
        </form>
      <?php endif ?>
    </div>
  </div>
</nav>