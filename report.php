<?php
$page = 'Report';

include './components/header.php';

include './components/navbar.php';

?>
<div class="container mt-30">
  <div class="row mt-5">
    <div class="col-lg-8 mx-auto">
      <div class="card">
        <h3 class="t-black semi-header">Report</h3>
        <p class="medium-header t-black my-3"><strong>Warning!!</strong> if you get error or bug in my website you can report to me via email</p>
        <form action="https://formsubmit.co/muhammaddzakiardiansyah811@gmail.com" class="mt-3 font-primary" method="post" id="report">
          <div class="mb-3">
            <label for="subject" class="form-label t-black medium-header">Subject <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject">
          </div>
          <div class="mb-3">
            <label for="body" class="form-label t-black medium-header">Body <span class="text-danger">*</span></label>
            <textarea name="body" id="body" rows="4" placeholder="Enter body" class="form-control"></textarea>
          </div>
          <button class="btn btn-primary mt-4"><i class="bi bi-send"></i> Send</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $().ready(() => {
    $("#report").validate({
      rules: {
        subject: {
          required: true,
          minlength: 5,
        },
        body: {
          required: true,
          minlength: 5,
        }
      }
    })
  })
</script>
<?php
include './components/footer.php';
?>