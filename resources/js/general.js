/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $('.menufilter').keyup(function () {
            var filter = $(this).val();

            $(this).next("ul").children("li").each(function () {
                if (filter == "") {
                    $(this).css("visibility", "visible");
                    $(this).fadeIn();
                } else if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).css("visibility", "hidden");
                    $(this).fadeOut();
                } else {
                    $(this).css("visibility", "visible");
                    $(this).fadeIn();
                }
        });
//        var input, filter, ul, li, a, i, txtValue;
//        input = $(this).val();
//        filter = input.toUpperCase();
//        ul =  document.getElementsByClassName('myUL') ;//document.getElementById("myUL");
//        li = ul.getElementsByTagName('li');
//
//        // Loop through all list items, and hide those who don't match the search query
//        for (i = 0; i < li.length; i++) {
//            a = li[i].getElementsByTagName("p")[0];
//            txtValue = a.textContent || a.innerText;
//            if (txtValue.toUpperCase().indexOf(filter) > -1) {
//                li[i].style.display = "";
//            } else {
//                li[i].style.display = "none";
//            }
//        }
    });
});
/*
Dino
Date: 31-07-19
Requirement: Image Rotate
*/
$(document).ready(function(){
	var angle = 0;
	$('#rotateRight').on('click', function() {
		angle += 90;
		$("#attachment-image").rotate(angle);
    });
    $('#rotateLeft').on('click', function() {
		angle -= 90;
		$("#attachment-image").rotate(angle);
	});
});
