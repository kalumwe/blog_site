 $(document).ready(function(){
      $('.post-entry-1').click(function(){
        location.replace('index.php?page=single-post&id='+$(this).attr('data-id'))
      })
    })
 
//Ajax using GET to like item  
  function  likeComment(productId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Request was successful, update the button text and disable the button
            const likeCommentBtn = document.getElementById('likeComment_'+productId+'');
            likeCommentBtn.className = 'bi-heart-fill mr-2';
            likeCommentBtn.style.color = 'red';
            
            // Optionally, you can also update the cart status on the page
           // document.getElementById('cartStatus').innerHTML = xhr.responseText;
            } else {
              const likeCommentBtn = document.getElementById('likeComment_'+productId+'');
              likeCommentBtn.className = 'bi-heart mr-2';
            
            }
        };
        xhttp.open("GET", "./forms/like_comment.php?id="+ productId, true);
        xhttp.send();
        
}

//show error message if form input is empty after submission

// -------------------------SEARCH------------------------------------------
  function submitSearch() {
        var form = document.searchForm;
        if (form.search_post.value == "") {
            document.getElementById('search_error').innerHTML = "Search post.";
            //alert("Search something.");
            form.search_post.focus();
            return false;
            } 
  }

  function disappear() { 
      document.getElementById('search_error').innerHTML = '';
  }

//show form when reply button is clicked    
  function displayReplyForm(id) {
  
    const hiddenElement = document.getElementById('replyForm_'+id+'');

    // Toggle the visibility of the element by changing the display property
    if (hiddenElement.style.display === 'none') {
        hiddenElement.style.display = 'block'; // Or 'inline-block' or 'flex', depending on your layout needs
    } else {
        hiddenElement.style.display = 'none';
    }
  }



    