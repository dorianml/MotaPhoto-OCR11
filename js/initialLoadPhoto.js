document.addEventListener("DOMContentLoaded", function () {
  // Invoke the function directly when the page is loaded
  initialLoadPhoto();

  // Function to retrieve the last 8 uploaded photos
  function initialLoadPhoto() {
    let formData = new FormData();
    formData.append("action", "request_initial_load_photo");

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
        } else {
          console.error("No posts found.");
        }
      })
      .catch(function (error) {
        console.error("There was a problem with the fetch operation: ", error);
      });
  }

  // Function to generate HTML structure for each post
  function generatePostHTML(post) {
    return `
    <div class="grid-item-index">
    <a href="${post.post_permalink}">
      <img src="${post.post_thumbnail}" alt="${post.post_title}">
    </a>
    <a href="${post.post_thumbnail}" class="focusIcon">
    </a>
    <div class="eyeIcone"></div>
    <div class="previewREF">${post.post_reference}</div> 
    <div class="previewCAT">${post.post_category}</div> 
  </div>`;
  }
});
