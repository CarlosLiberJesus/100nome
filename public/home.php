<div class="banner">
    <video loop autoplay muted class="w-100 d-block">
        <source src="video/100nome.mp4" type="video/mp4" class="w-100 d-block">
    </video>
    <div class="mx-3 pb-3 mt-5">
      <form action="index.php?task=subscribe" method="post" name="subscribe_form">
        <div class="row g-2 justify-content-end ">
          <div class="col-12 col-md-auto d-flex flex-column align-items-end">
            <span class="mb-1 unifrakturcook-bold" style="display:list-item;font-size:large;"
              id="subscribe_label">Subscreva a nossa newsletter:</span>
            <input class="form-control mb-2 w-100 condiment-regular" type="email" name="email" id="subscribe_email"
              placeholder="oseu@email.com" required />
            <button type="submit" class="btn bg-grey mt-1 w-100 unifrakturcook-bold" value="" id="subscribe_button"
              style="color:white;font-weight:bold">Subscrever</button>
          </div>
          <div class="col-12 col-md-auto">
            <textarea class="form-control w-100 condiment-regular" placeholder="Deixe uma mensagem" rows="5"
              name="message" id="subscribe_message"></textarea>
          </div>
        </div>
      </form>
    </div>
</div>