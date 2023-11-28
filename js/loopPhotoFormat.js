document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".ajax-format-link").forEach(function (link) {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        console.log("AJAX-FORMAT");
  
        let formatID = this.getAttribute("data-format-id");
  
        // Log the formatID for debugging
        console.log("Format ID:", formatID);
  
        let formData = new FormData();
        formData.append("action", "request_loop_photo_format");
        formData.append("format_id", formatID);
        formData.append("taxonomy", "format"); // Change 'categ' to 'format'
  
        fetch("/wp-admin/admin-ajax.php", {
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
                    '<div class="related-posts-grid"><a href="' +
                      post.post_permalink +
                      '"><img src="' +
                      post.post_thumbnail +
                      '" alt="' +
                      post.post_title +
                      '"></a></div>'
                  );
              });
            } else {
              console.error("No posts found.");
            }
          })
          .catch(function (error) {
            // Log specific error message for debugging
            console.error("Error during fetch operation:", error.message);
          });
      });
    });
  });
  