if(document.getElementById('post-form')){
  const FORM_POST = document.getElementById('post-form');
  const SUBMIT_BTN = document.getElementById('submit-btn');

  FORM_POST.addEventListener('submit', function(e) {
    e.preventDefault()
    
  });

  window.addEventListener('load', function(e) {
    e.preventDefault()
    
});

  SUBMIT_BTN.addEventListener('click', function() {
    FORM_POST.submit();
  })

  }

if(document.getElementById('update-form-btn')){
  const EDIT_BTN = document.getElementById('update-form-btn');
  const UPDATE_FORM = document.querySelector('.update-form-container');
  const CLOSE_ICON = document.getElementById('update-close-icon');
  

  EDIT_BTN.addEventListener('click', showForm)
  CLOSE_ICON.addEventListener('click', closeForm);
 
  function showForm(){
    UPDATE_FORM.style.display = "block";
    document.body.style.overflow = "hidden";
  }
  function closeForm(){
    UPDATE_FORM.style.display = "none";
    document.body.style.overflow = "visible";
  }

  
}

if(document.getElementById('following-container')){
  const FOLLOWING_CONTAINER = document.getElementById('following-container');
  const CLOSE_FOLLOWING_ICON = document.getElementById('showFollowing-close-icon');
  const FOLLOWING_p = document.getElementById('following');

  FOLLOWING_p.addEventListener('click', showFollowing);
  CLOSE_FOLLOWING_ICON.addEventListener('click', closeFollowing);


  function showFollowing(){
    FOLLOWING_CONTAINER.style.display = "block";
  }

  function closeFollowing(){
    FOLLOWING_CONTAINER.style.display = "none";
  }


}

if(document.getElementById('followed-container')){
  const FOLLOWING_CONTAINER = document.getElementById('followed-container');
  const CLOSE_FOLLOWING_ICON = document.getElementById('showFollowed-close-icon');
  const FOLLOWING_p = document.getElementById('followed');

  FOLLOWING_p.addEventListener('click', showFollowing);
  CLOSE_FOLLOWING_ICON.addEventListener('click', closeFollowing);


  function showFollowing(){
    FOLLOWING_CONTAINER.style.display = "block";
  }

  function closeFollowing(){
    FOLLOWING_CONTAINER.style.display = "none";
  }


}

if(document.getElementById('post-focus')){
  const closeIcon = document.getElementById('close-comment');
  const comment = document.getElementById('post-focus');

  if(comment.style.display !== "none"){
    document.body.style.overflow = "hidden";
  }

  closeIcon.addEventListener('click', closeComment)

  function closeComment(){
    comment.style.display = "none";
    document.body.style.overflow = "visible";
  }

}

if(document.getElementById('show-post-action')){
  const SHOW_POST_ACTION = document.getElementById('show-post-action');
  const SHOW_LIKE_ACTION = document.getElementById('show-liked-action');
  const POST_CONTAINER = document.querySelector('.show-post');
  const LIKE_CONTAINER = document.querySelector('.show-liked-post');

  SHOW_POST_ACTION.addEventListener('click', showPost);
  SHOW_LIKE_ACTION.addEventListener('click', showLike);

  function showPost(){
    SHOW_POST_ACTION.classList.add("post-and-like-container-active");
    POST_CONTAINER.style.display = "block";
    LIKE_CONTAINER.style.display = "none";  
    SHOW_LIKE_ACTION.classList.remove("post-and-like-container-active"); 
  }

  function showLike(){
    SHOW_POST_ACTION.classList.remove("post-and-like-container-active");
    POST_CONTAINER.style.display = "none";
    LIKE_CONTAINER.style.display = "block";
    SHOW_LIKE_ACTION.classList.add("post-and-like-container-active");
  }

}

console.log(document.getElementById("loadUsers"));


document.addEventListener("DOMContentLoaded", function() {
 console.log("test");
 
  fetch("http://localhost:8000/test")
      .then(response => response.json())
      .then(data => {
        console.log(data);
        
          let userList = document.getElementById("postList");
          userList.innerHTML = "";
          data.forEach(post => {
            userList.innerHTML +=  `  <div class="post">
            <a href="/profile?id=${post.user_id}">
              <div class="post-user-info">
                <div class="user-img">
                  <img src="/public/uploads/${post.profile_picture || "img_default.png"}" alt="${post.username} profile pciture">
                </div>
            </a>
            <a href="/post?id=${post.id}">
              <h5>${post.username}</h5>
          </div>
          <p>${post.content}</p>
          </a>
          <div class="post-icon-container">
            <div class="d-flex comment-icon-container">
              <form method="POST">
                <input type="hidden" name="idPost" value="${post.id}">
                <button type="submit" class="add-comment-btn"><i class="fa-regular fa-comment" id="comment-icon"></i></button>
              </form>
                <p class="ms-1 number-comment">${post.comment_count}</p>
            </div>
            <div class="d-flex heart-icon-container">
              <form method="POST">
                <input type="hidden" name="idLike" value="${post.id}">
                <button type="submit" class="add-like-btn"><i class="fa-regular fa-heart heart-icon"></i></button>
              </form>
                <p class="ms-1 number-comment">${post.like_count}</p>
            </div>
              ${userId == post.user_id ? `
              <div class="delete-icon-container">
                <form method="POST">
                  <input type="hidden" name="idPostDelete" value="${post.id}">
                  <button type="submit" class="delete-post-btn"><i class="fa-regular fa-trash-can delete-icon"></i></button>
                </form>
              </div>` : ""}
          </div>
  </div>`
               // Créer la section du contenu du post
              
          });
      })
      .catch(error => console.error("Erreur:", error));
});


