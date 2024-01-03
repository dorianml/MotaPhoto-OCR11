document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".ajax-LOAD-link").forEach(function (link) {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        console.log("AJAX-LOAD_ALL");
  
        const dropMenus = document.querySelectorAll(".filter-drop-menu");
  
        dropMenus.forEach(function (dropMenu) {
          dropMenu.classList.add("closeFilter");
          dropMenu.style.display = "none"; // or set the initial display style to whatever you need
        });
  
        let formatID = this.getAttribute("data-format-id");
        let categoryID = this.getAttribute("data-category-id");
        let order = this.getAttribute("data-order");
  
        console.log("Format ID:", formatID);
        console.log("Category ID:", categoryID);
  
        let formData = new FormData();
  
        if (formatID !== null && formatID !== undefined && formatID !== "") {
          formData.append("format_id", formatID);
        }
  
        // Append category_id if it is not empty
        if (categoryID !== null && categoryID !== undefined && categoryID !== "") {
          formData.append("category_id", categoryID);
        }
  
        // Append order if it is not empty
        if (order !== null && order !== undefined && order !== "") {
          formData.append("order", order);
        }
  
        formData.append("action", "request_load_photo");
  
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
            console.log("Order:", order);
  
            if (data.posts) {
              data.posts.forEach(function (post) {
                //   console.log("Post Object:", post);
                document
                  .querySelector("#ajax_return")
                  .insertAdjacentHTML("beforeend", generatePostHTML(post));
              });
              if (data.posts.length >= 6) {
                // If yes, show the "Load more" button
                document.querySelector(".btn__wrapper").style.display = "block";
  
                // Add event listener to the "Load more" button
                document
                  .getElementById("load-more")
                  .addEventListener("click", loadMorePosts);
              }
              //      If no more posts to load, hide the "Load more" button
              if (data.posts.length < 8) {
                document.querySelector(".btn__wrapper").style.display = "none";
              }
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
        <a href="${post.post_thumbnail}" class="focusIcon .preview">
        </a>
        <a href="${post.post_permalink}"> <div class="eyeIcone"> </div> </a>
        <div class="previewREF .preview">${post.post_reference}</div> 
        <div class="previewCAT .preview">${post.post_category}</div> 
      </div>`;
    }
  });
  
  // Function to load more posts
  function loadMorePosts() {
    let formData = new FormData();
    formData.append("action", "request_load_photo");
    formData.append(
      "offset",
      document.querySelectorAll(".grid-item-index").length
    );
  
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
  