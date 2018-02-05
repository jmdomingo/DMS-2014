
function validateQuery(){
	
	alert( document.getElementById("name").value + " " + document.getElementById("desc").value);
	
	var error = 0;		
	var iChars = "\n Ò—abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890\"-,'.%#()";//Allowed characters for Subject and Purpose
	var qChars = "\n Ò—abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890\".',=%_()*";//Allowed characters for Query
	var invalidText = 0;
	
	/** CHECKING SUBJECT STATEMENT*****************************************************/
	var subject = document.getElementById("name").value;
	if(subject == ""){
		errsub.style.display = "block";
		error++;
	}
	else{
		for (var i = 0; i < subject.length; i++) {
			chr = subject.charAt(i);
			var cc = subject.charCodeAt(i);
			if (iChars.indexOf(chr) > -1) {
			}
			else if (cc == 241){
			}
			else if (cc == 209){
			}
			else{
				invalidText = 1;
			}
		}
		errsub.style.display = "none";
	}
	if(invalidText == 1){
		errsub2.style.display = "block";
		error++;
	}
	else{
		errsub2.style.display = "none";
	}
	/** CHECKING PURPOSE STATEMENT*****************************************************/
	var purpose = document.getElementById("desc").value;
	invalidText = 0;
	if(purpose == ""){
		errpur.style.display = "block";
		error++;
	}
	else{
		for (var i = 0; i < purpose.length; i++) {
			chr = purpose.charAt(i);
			var cc = purpose.charCodeAt(i);
			if (iChars.indexOf(chr) > -1) {
			}
			else if (cc == 241){
			}
			else if (cc == 209){
			}
			else{
				invalidText = 1;
			}
		}			
		errpur.style.display = "none";
	}
	if(invalidText == 1){
		errpur2.style.display = "block";
		errorName = 1;
		error++;
	}
	else{
		errpur2.style.display = "none";
	}
	/** CHECKING QUERY STATEMENT*****************************************************/
	var query = document.getElementById("query").value;
	invalidText = 0;
	if(query == ""){
		errque.style.display = "block";
		error++;
	}
	else{
		for (var i = 0; i < query.length; i++) {
			chr = query.charAt(i);
			var cc = query.charCodeAt(i);
			if (qChars.indexOf(chr) > -1) {
			}
			else if (cc == 241){
			}
			else if (cc == 209){
			}
			else{
				invalidText = 1;
			}
		}			
		errque.style.display = "none";
	}
	if(invalidText == 1){
		errque2.style.display = "block";
		errorName = 1;
		error++;
	}
	else{
		errque2.style.display = "none";
	}
	
	/** CHECKING TYPE SELECTED*****************************************************/	
	var type = document.getElementById("type").value;
	if(type == -2){ 
		errtyp.style.display = "block"; 
		error++; 
	} else{ 
		errtyp.style.display = "none"; 
	}
	
	
	
	/*
	*  DISPLAY ALL THE ERRORS
	*/
	if(error > 0){
		parent.scrollTo(100, 100);
		return false;
	} else{
		var answer = confirm("Kindly check first if all data are correct, click 'yes' to ADD this New BCC?");
		if(answer){
			return true;
		}
		else{
			return false;
		}
	}
	/*
	*  END OF VALIDATION
	*/
}

