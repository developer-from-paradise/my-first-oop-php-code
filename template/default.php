<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doodle - Search Engine</title>
    <link rel="stylesheet" href="template/css/style.css">
    <link rel="stylesheet" href="template/css/responsive.css">
</head>
<body>

<header class="header">

    <div class="brand">Doodle</div>

    <form class="form">
        <input type="text" placeholder="Query..." name="search" class="input-search">
        <input type="submit" value="Search" class="btn-search">
    </form>
</header>


<div id="content">
</div>
<div class="modal"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
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
</body>
</html>