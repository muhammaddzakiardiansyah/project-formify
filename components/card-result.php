<div class="show-result card b-white mb-3 d-none">
  <div class="card-body">
    <p class="t-black medium-header">Total Result : <?= count($answers) ?></p>
  </div>
  <div class="card-body">
    <div class="accordion accordion-flush" id="accordionFlushExample">
      <?php if ($answers != []) : ?>
        <?php foreach ($answers as $answer) : ?>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed t-black font-primary" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $answer["id"] ?>" aria-expanded="false" aria-controls="<?= $answer["id"] ?>">
                <?= $answer["username"] ?? "Anonyimus" ?>
              </button>
            </h2>
            <div id="<?= $answer["id"] ?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                <table class="table">
                  <thead>
                    <th>Question</th>
                    <th>Answer</th>
                  </thead>
                  <tbody>
                    <?php
                      $key_answers = explode(",", $answer["key_answers"]);
                      array_pop($key_answers);
                      $answers = explode(",", $answer["answers"]);
                    ?>
                    <?php for($i = 3; $i < count($key_answers); $i++) : ?>
                      <tr>
                        <td class="t-black medium-header"><?php $key = explode("_", $key_answers[$i]); echo implode(" ", $key); ?></td>
                        <td class="t-black medium-header"><?= $answers[$i] ?></td>
                      </tr>
                    <?php endfor; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="card-body">
          <h4 class="t-black medium-header">No response has been sent yet</h4>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>