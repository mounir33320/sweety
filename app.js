$(function(){
	$(".delete").click(function(e){
		if(confirm("Êtes-vous certain de vouloir supprimer ce code ?")){

		}
		else{
			e.preventDefault();
		}
	})

	if($(location).attr("href") == "http://localhost/sweety/admin?del=" ){
		console.log("test");
	}
})