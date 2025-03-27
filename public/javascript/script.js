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



