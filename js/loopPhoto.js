document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".ajax-category-link").forEach(function (link) {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      console.log("AJAX");

      let categoryID = this.getAttribute("data-category-id");
      console.log("Category ID:", categoryID);
      let formData = new FormData();
      formData.append("action", "request_loop_photo");
      formData.append("category_id", categoryID);

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
                .insertAdjacentHTML("beforeend", generatePostHTML(post));
            });

            // Check if there are more posts to load
            if (data.posts.length >= 8) {
              // If yes, show the "Load more" button
              document.querySelector(".btn__wrapper").style.display = "block";

              // Add event listener to the "Load more" button
              document.getElementById("load-more").addEventListener("click", loadMoreCategoryPosts.bind(null, categoryID));
            }
          } else {
            console.error("No posts found.");
          }
        })
        .catch(function (error) {
          console.error("There was a problem with the fetch operation: ", error);
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
      <a href="${post.post_thumbnail}" class="focusIcon .preview">
      </a>
      <a href="${post.post_permalink}"> <div class="eyeIcone"> </div> </a>
      <div class="previewREF .preview">${post.post_reference}</div> 
      <div class="previewCAT .preview">${post.post_category}</div> 
    </div>`;
  }

  // Function to load more posts for a specific category
  function loadMoreCategoryPosts(categoryID) {
    let formData = new FormData();
    formData.append("action", "load_more_category_photo_posts");
    formData.append("category_id", categoryID);
    formData.append("offset", document.querySelectorAll(".grid-item-index").length);

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
        if (data.posts) {
          data.posts.forEach(function (post) {
            document
              .querySelector("#ajax_return")
              .insertAdjacentHTML("beforeend", generatePostHTML(post));
          });

          // If no more posts to load, hide the "Load more" button
          if (data.posts.length < 8) {
            document.querySelector(".btn__wrapper").style.display = "none";
          }
        } else {
          console.error("No more posts found.");
        }
      })
      .catch(function (error) {
        console.error("There was a problem with the fetch operation: ", error);
      });
  }
});
