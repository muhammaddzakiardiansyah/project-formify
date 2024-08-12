<div class="form-question card b-white mb-3 d-none">
  <form action="" class="font-primary" id="create_question" method="post">
    <div class="card-body">
      <h4 class="semi-header t-black mb-30">Create New Question</h4>
      <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?? "awokawok" ?>">
      <input type="hidden" name="form_id" value="<?= $form["id"] ?? "0" ?>">
      <div class="mb-4">
        <label class="t-black medium-header mb-10" for="question">Question</label>
        <input type="text" name="question" id="question" placeholder="Enter question" class="form-control font-primary">
      </div>
      <div class="mb-4">
        <label class="t-black medium-header mb-10" for="type_question">Type Question</label>
        <select class="form-select" id="type_question" name="type_question" aria-label="Default select example">
          <option value="" selected>Open this select menu</option>
          <option value="input">Input</option>
          <option value="textarea">Textarea</option>
          <option value="combobox">Combobox</option>
        </select>
      </div>
      <div class="mb-4 input-answers d-none">
        <label class="t-black medium-header mb-10" for="answers">Answers</label>
        <input type="text" name="answers" id="answers" placeholder="Enter answers question sprate with coma" class="form-control font-primary">
      </div>
      <div class="mb-4">
        <label class="t-black medium-header mb-10">Is Required</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="is_required" id="required" value="1">
          <label class="form-check-label" for="required">
            Yes this question required
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="is_required" id="not_required" value="0" checked>
          <label class="form-check-label" for="not_required">
            No this question not required
          </label>
        </div>
      </div>
      <button class="btn btn-primary mt-4" type="submit" name="create_question"><i class="bi bi-file-earmark-plus"></i> Create</button>
    </div>
  </form>
</div>