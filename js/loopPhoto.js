document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".ajax-category-link").forEach(function (link) {
      link.addEventListener("click", function (event) {
          event.preventDefault();
          console.log('AJAX')

          let categoryID = this.getAttribute("data-category-id");
          console.log("Category ID:", categoryID);
          let formData = new FormData();
          formData.append("action", "request_loop_photo");
          formData.append("category_id", categoryID);

          fetch('/wp-admin/admin-ajax.php', {
              method: "POST",
              body: formData,
          })
              .then(function (response) {
                  if (!response.ok) {
                      throw new Error("Network response error.");
                  }

                  return response.json();
              })
              .then(function (data) {
                  document.querySelector("#ajax_return").innerHTML = "";

                  // Log the entire data.posts array to the console
                  console.log("JSON Response:", data.posts);

                  if (data.posts) {
                      data.posts.forEach(function (post) {
                          document
                              .querySelector("#ajax_return")
                              .insertAdjacentHTML(
                                  "beforeend",
                                  '<div class="related-posts-grid"><a href="' + post.post_permalink + '"><img src="' + post.post_thumbnail + '" alt="' + post.post_title + '"></a></div></div>'
                              );
                      });
                  } else {
                      console.error("No posts found.");
                  }
              })
              .catch(function (error) {
                  console.error(
                      "There was a problem with the fetch operation: ",
                      error
                  );
              });
      });
  });
});
