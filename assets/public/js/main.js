jQuery(document).ready(function ($) {
  jQuery("button.spld-btn").click(function (e) {
    e.preventDefault();

    var response_div = $("#spld_ajax_response");
    response_div.html("");

    if (data.user_id === "0") {
      response_div.html(
        "<a href='" + data.login_url + "'>Login</a> to send your feedback."
      );
      return;
    }

    var $this = $(this);
    $this.prop("disabled", true).addClass("is-processing");
    var count_span = $this.find(".count");

    post_id = $(this).attr("data-post_id");
    type = $(this).attr("data-type");

    // nonce = $(this).attr("data-nonce");
    $.ajax({
      type: "post",
      dataType: "json",
      url: data.ajax_url,
      //   data: { action: "my_user_like", post_id: post_id, nonce: nonce },
      data: {
        action: "spld_handle_like_dislike",
        post_id: post_id,
        type: type,
      },
      success: function (response) {
        if (response.type == "success") {
          if (type === "like") {
            $this.addClass("active").removeClass("is-processing");

            //Increment like count.
            increment_count(count_span);

            var dislike_btn = $(".spld-dislike-btn");

            // Enable button end decrement dislike count.
            dislike_btn.removeClass("active").prop("disabled", false);
            var dislike_count_span = dislike_btn.find(".count");

            var dislike_count = parseInt(dislike_count_span.text());

            // Only decrement if count is greater than 0 other -negative
            if (dislike_count > 0) {
              dislike_count_span.text(dislike_count - 1);
            }
          } else {
            $this.addClass("active").removeClass("is-processing");

            //Increment dislike count.
            increment_count(count_span);

            // Enable button end decrement like count.
            var like_btn = $(".spld-like-btn");
            var like_count_span = like_btn.find(".count");
            like_btn.removeClass("active").prop("disabled", false);

            var like_count = parseInt(like_count_span.text());

            // Only decrement if count is greater than 0 other -negative
            if (like_count > 0) {
              like_count_span.text(like_count - 1);
            }
          }
        } else {
          // alert("Something went wrong.");
        }
        response_div.html(response.message);
      },
    });
  });
});

function increment_count(count_span) {
  var like_count = parseInt(count_span.text() + 1);
  count_span.text(like_count);
}
