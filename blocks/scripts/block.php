<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$("input[type='']").keypress(function(event){
    var ew = event.which;
    if(ew == 32)
        return true;
    if(48 <= ew && ew <= 57)
        return true;
    if(65 <= ew && ew <= 90)
        return true;
    if(97 <= ew && ew <= 122)
        return true;
    return false;
});


$body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});

function createElementFromHTML(htmlString) {
  var div = document.createElement('div');
  div.innerHTML = htmlString.trim();

  return div.firstChild;
}

function ShowResult(result){
    var data = JSON.parse(result, content);
    
    
    
    data['value'].forEach(item => {
        if(item['image']['url'] == ""){
            item['image']['url'] = "https://styleguide.iu.edu/images/3-2_placeholder_768px-512px.png";
        }
        var div = `
<div class="item">
    <h1 class="title">${item['title']}</h1>
    <img src="${item['image']['url']}" alt="" class="image">
    <p class="paragraph">${item['description']}<br><br>${item['body']}</p>
    <a href="${item['url']}" class="link" target="_blank">More</a>
</div>`;
    div = createElementFromHTML(div);
    content.appendChild(div);
    });
}




$('.btn-search').click(function(e) {
    var search = document.querySelector('.input-search').value;
    var content = document.querySelector('#content');
    $('#content > div').remove();
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: "api.php",
        data: { requests: search.replace(/ /g, "%20")},
        success: (function(result){
            console.log(result);
            ShowResult(result, content);
        })
    })
});




</script>