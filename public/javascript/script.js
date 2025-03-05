if(document.getElementById('post-form')){
  const FORM_POST = document.getElementById('post-form');
  const SUBMIT_BTN = document.getElementById('submit-btn');

  FORM_POST.addEventListener('submit', function(e) {
    e.preventDefault()
    console.log('test');
    
  });

  window.addEventListener('load', function(e) {
    e.preventDefault()
    console.log('test');
    
});

  SUBMIT_BTN.addEventListener('click', function() {
    FORM_POST.submit();
  })

  }






