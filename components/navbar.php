<nav class="navbar navbar-expand-lg">
  <div class="container b-black nav">
    <a class="navbar-brand t-white semi-header d-flex align-items-center gap-2" href="/project-formify">
      <img src="/<?= $project_name ?>/assets/images/logo-formify.png" alt="logo formify" width="35" height="35" class="img-navbar">
      <span class="title-navbar">Formify</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link t-white d-flex column-gap-2" aria-current="page" href="/project-formify"><i class="bi bi-house"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link t-white d-flex column-gap-2" href="create-form"><i class="bi bi-file-earmark-plus"></i> Create Form</a>
        </li>
        <li class="nav-item">
          <a class="nav-link t-white d-flex column-gap-2" href="show-form"><i class="bi bi-card-list"></i> Show Form</a>
        </li>
        <li class="nav-item">
          <a class="nav-link t-white d-flex column-gap-2" href="report"><i class="bi bi-flag"></i> Report</a>
        </li>
      </ul>
      <?php if (isset($_SESSION["user_login"]) && $_SESSION["user_login"]["login"] === true) : ?>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION["user_login"]["username"] ?>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item font-primary t-black" href="#"><i class="bi bi-person"></i> Profile</a></li>
            <li><a class="dropdown-item font-primary t-black" onclick="return confirm('Sure Logout?')" href="logout"><i class="bi bi-box-arrow-left"></i> Logout</a></li>

          </ul>
        </div>
      <?php else : ?>
        <a href="login" class="btn btn-primary"><i class="bi bi-box-arrow-in-right"></i> Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>