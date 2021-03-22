// var option = document.getElementByName('audioType');


// for (var i = 0, length = option.length; i < length; i++) {
//   if (option[i].checked) {
//     // do whatever you want with the checked radio
//     alert(option[i].value);

//     // only one radio can be logically checked, don't check the rest
//     break;
//   }
// }

$("#upload").change(function(){
	console.log($(this).val());
	$("#ytLinkBox").hide();
	$("#uploadBox").show();
	$("#ytLink").val('');
});

$("#stream").change(function(){
  console.log($(this).val());
	$("#ytLinkBox").show();
	$("#uploadBox").hide();
	$("#file").val('');
    
});