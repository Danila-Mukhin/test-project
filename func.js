$(document).ready(function(){
$('#search-button').click(function(evt){
if($('#search-input').val().length >= 3){
function f(data){	
let obj = $.parseJSON(data);
let strHTML=""; let comments=0;
for(let i=0; i<obj.postTitle.length; i++){	
strHTML = '<div class="post"><div class="post-title">Пост "'+obj.postTitle[i]+'"</div><div>Комментарии:</div>';
for(let i2=0; i2<obj.postComment[i].length; i2++){//
comments++;
strHTML += '<div class="post-comment">'+obj.postComment[i][i2]+'</div>';
}
strHTML += '</div>';
$('.content').append(strHTML);
}
console.log("Записей - "+obj.postTitle.length);
console.log("Комментариев - "+comments);
}	
$.post('http://localhost/test.php', {'value': $('#search-input').val()}, f);	
}else{
alert('Введите минимум 3 символа!');	
}
});
});