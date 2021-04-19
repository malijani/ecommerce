<div class="col-12">
    <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">

        <input type="radio" id="star5" name="rating" value="5" {{ ($user_rate && $user_rate == 5) ? 'checked' : ''}} />
        <label for="star5" title="۵ ستاره"></label>

        <input type="radio" id="star4" name="rating" value="4" {{ ($user_rate && $user_rate == 4) ? 'checked' : ''}} />
        <label for="star4" title="۴ ستاره"></label>

        <input type="radio" id="star3" name="rating" value="3" {{ ($user_rate && $user_rate == 3) ? 'checked' : ''}} />
        <label for="star3" title="۳ ستاره"></label>

        <input type="radio" id="star2" name="rating" value="2" {{ ($user_rate && $user_rate == 2) ? 'checked' : ''}} />
        <label for="star2" title="۲ ستاره"></label>

        <input type="radio" id="star1" name="rating" value="1" {{ ($user_rate && $user_rate == 1) ? 'checked' : ''}} />
        <label for="star1" title="۱ ستاره"></label>

    </div>
</div>

