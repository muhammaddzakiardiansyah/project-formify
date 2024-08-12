<?php
include './components/header.php';

include './components/navbar.php';

?>
<div class="container mt-30">
  <div class="row">
    <div class="col-lg-6">
      <div class="row mt text-warp">
        <div class="col-lg-12">
          <h2 class="t-black super-big-header">Create a question form<br> or something else with <span class="t-blue">Formify</span></h2>
          <h4 class="t-black semi-header mb-30">makes it easier for you to create form</h4>
          <a href="create-form" class="btn btn-primary mr-10">Get Started</a>
          <a href="#" class="btn btn-secondary">Learn More</a>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="row text-center img-warp">
        <div class="col-lg-12">
          <img src="/<?= $project_name ?>/assets/images/forms-logo.svg" alt="logo forms" width="550" height="430">
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include './components/footer.php';
?>