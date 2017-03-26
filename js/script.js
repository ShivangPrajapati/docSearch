$(document).ready(function() {
    $('select').material_select();

    $('.modal').modal();
  
  });

$("#query").change(function(){
		$("#search").trigger("click");
	});

$("#uploadFile").click(function(){
	var fileData = $("#uploadTarget").prop('files')[0];
	if(fileData == null)
	{
		alert("Please select the file ...");
		return false;
	}
	var formData = new FormData();
	formData.append('file',fileData);
	$.ajax({
		url : 'addDoc.php',
			dataType : 'text' , //what to expect from the server
			cache : false,
			contentType : false,
			processData : false,
			data : formData,
			type: 'post',
			success : function(response)
			{
				alert(response);
			}
		});
	});



 


String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}


function createCard (fileName, downloadLocation, type , size, dateModified , fileId)
{
	return  "<div class='col s12 m12'>"+
			"<div class='card blue lighten-1'>"+
			" <div class='card-content black-text'>"+
			"<span class='card-title truncate'><b>"+fileName+"</b></span>"+
			"<p> File Type : "+type.capitalize()+"</p>"+
			"<p> File Size : "+size+" kb</p>"+
			Date(dateModified)+
			"</div>"+
			"<div class = 'card-action'>"+
			"<a href='"+downloadLocation+"' class = 'white-text' target = '_new'>View</a>"+
			"<a href='"+downloadLocation+"' class = 'white-text' download>Download</a>"+
			"</div>"+
			"</div>"+"</div>";
	
}

$("#search").click(function(){
	var query = $("#query").val();
	var cat = $('#searchType').val();
	var formData = new FormData();
	formData.append('query',query);
	if(cat)
		formData.append('type',cat);
	$.ajax({
		url : 'searchDoc.php',
		dataType: 'text',
		cache: false, 
		contentType: false,
		processData : false,
		data: formData,
		type: 'post',
		success:function (response)
		{
			$('#searchResult').hide();
			$('#searchResult').empty();
			var array = JSON.parse(response);
			if ( array == null )
			{
				$("#searchResult").append("<div class='col s12 m6'><div class='card white darken-1'><div class='card-content black-text'><p>Sorry! No documents found !!!</p></div></div></div>");
				$('#searchResult').fadeIn();
				return ;
			}
			var content;
			for( i = 0 ; i < array.length ; i++)
			{
				content = createCard(array[i]['name'],array[i]['downloadLocation'],array[i]['type'] , array[i]['size'],array[i]['uploadDate'],array[i]['fileId']);
				$("#searchResult").append(content);
			}
			$('#searchResult').fadeIn();

		}
	});
});

