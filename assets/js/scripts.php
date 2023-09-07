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

