document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".ajax_time_link").forEach(function (link) {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        console.log("AJAX-TIME");
  
        let order = this.getAttribute("data-order");
  
        // Log the order for debugging
        console.log("Order:", order);
  
        let formData = new FormData();
        formData.append("action", "request_loop_photo_time");
        formData.append("order", order); // Add order to the formData
  
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
                    generatePostHTML(post)
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
  
    // Function to generate HTML structure for each post
    function generatePostHTML(post) {
      return `
          <div class="grid-item-index">
            <a href="${post.post_permalink}">
              <img src="${post.post_thumbnail}" alt="${post.post_title}">
            </a>
            <a href="${post.post_thumbnail}" class="focusIcon">
            </a>
          </div>`;
    }
  });
  