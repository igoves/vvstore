<h3 style="margin-top:0">Настройки</h3>

<form action="" method="post" class="ajaxform form-horizontal">

    <div class="panel-group" id="accordion">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

              Сайт - Общие настройки

          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
          <div class="panel-body">
           {main_settings}
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

             Сайт - Контакты

          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse in">
          <div class="panel-body">
            {contacts_info}
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

             Сайт - Позиций на странице

          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse in">
          <div class="panel-body">
            {items_per_page}
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

             Сайт - Картинки

          </h4>
        </div>
        <div id="collapse4" class="panel-collapse collapse in">
          <div class="panel-body">
            {images}
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

            Сайт - Дополнительно

          </h4>
        </div>
        <div id="collapse6" class="panel-collapse collapse in">
          <div class="panel-body">
           {addition}
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

            Настройки PayPal

          </h4>
        </div>
        <div id="collapse7" class="panel-collapse collapse in">
          <div class="panel-body">
            {paypal}
          </div>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">

            Административная часть

          </h4>
        </div>
        <div id="collapse7" class="panel-collapse collapse in">
          <div class="panel-body">
           {admin}
          </div>
        </div>
      </div>

    </div>

    <button type="submit" name="save" class="btn btn-lg btn-block btn-success" data-loading-text="Сохраняется...">Сохранить</button>
</form>